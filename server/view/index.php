<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Estación Meteorológica Los Pacos</title>
        <?php
        require_once '../common/config.php';
        // Preparar los datos para la representación gráfica
        // Conectar a la base de datos
        $dbhandle = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        // Mostrar mensaje de error para evitar un fallo brusco sin los parametros de conexión son incorrectos.
        if ($dbhandle->connect_error) {
            exit("There was an error with your connection: ".$dbhandle->connect_error);
        }
        $ActualTime = strtotime('now');
        $LastHour = strtotime('-8 hour', $ActualTime) * 1000;
        $Last24h = strtotime('-1 day', $ActualTime) * 1000;
        $LastMonth = strtotime ('-1 month', $ActualTime) * 1000;
        // Formar la instrucción SQL que recupera los datos de:
        // Viento
        $strQueryWind = "(SELECT start_ts, avg, max, min FROM wind WHERE start_ts > $LastHour ORDER BY start_ts ASC)";
        // Temperatura y Humedad
        $strQueryTempHum = "(SELECT ts, t, h FROM temp_hum WHERE ts > $Last24h ORDER BY ts ASC)";
        // Presión atmosférica
        $strQueryPress = "(SELECT ts, p FROM pressure WHERE ts > $Last24h ORDER BY ts ASC)";

        // Ejecutar la instrucción SQL, sino mostrar un mensaje de error:
        // Viento
        $resultWind = $dbhandle->query($strQueryWind) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
        // Temperatura y Humedad
        $resultTempHum = $dbhandle->query($strQueryTempHum) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");
        // Presión Atmosférica
        $resultPress = $dbhandle->query($strQueryPress) or exit("Error code ({$dbhandle->errno}): {$dbhandle->error}");

        // Recopilar datos de viento y formatearlos para el gráfico.
        // $WindMax = Datos de las rachas de viento con el formato '[Date.UTC('año, mes (0-11), dia, hora, minuto, segudo), velocidad],...'
        // $WindAvg = Datos de las medias de viento con el mismo formato.
        // $LastWindMax = último registro de velocidad máxima
        // $LastWindAvg = Último registro de velocidad media
        // $LastMeasureTime = Hora de la última medida
        if ($resultWind) {
            $WindMaxMin = "";
            $WindAvg = "";
            while ($rowWind = mysqli_fetch_array($resultWind)) {
                $WindMaxMin .= '[' . $rowWind["start_ts"] . ', ' . $rowWind["max"] . ', ' . $rowWind["min"] . '],';
                $WindAvg .= '['. $rowWind ["start_ts"] . ',' . $rowWind["avg"] . '],';
                $LastWindMax = $rowWind["max"];
                $LastWindAvg = $rowWind["avg"];
                $LastMeasureTime = $rowWind["start_ts"];
            }
        }
        // Eliminar la coma final.
        $WindMaxMin = substr ($WindMaxMin, 0, -1);
        $WindAvg = substr ($WindAvg, 0, -1);
        $WindAll = '[' . $WindMaxMin . '], averages = [' . $WindAvg . ']';
        // Recopilar datos de Presión Atmosférica y formatearlos para el gráfico
        // $Press = Datos de la presión atmosférica con el formato '[Date.UTC(año, mes (0-11), dia, hora, minuto, segundo), Presión],...'
        // $LastPress = Último registro de presión atmosférica
        if ($resultPress){
            $Press="";
            while ($rowPress = mysqli_fetch_array($resultPress)) {
                 $Press .= '[' . $rowPress["ts"] . ', ' . $rowPress["p"] . '],';
                $LastPress = $rowPress["p"];
            }
        }
        // Eliminar la coma final.
        $Press = substr ($Press, 0, -1);

        // Recopilar los datos de temperatura y humedad
        // $Cats = Categorías (Eje X) con el formato 'día-mes-año Hora:minutos',...''
        // $Temp = Datos de la temperatura con el formato de matriz: a,b,c,d,e...
        // $Hum = Datos de la humedad relativa con el formato de matriz: a,b,c,d,e...
        // $LastTemp = Última temperatura registrada
        // $LastHum = Última humedad relativa registrada
        if ($resultTempHum) {
            $Cats = "";
            $Temp = array();
            $Hum = array();;
            while ($rowTempHum = mysqli_fetch_array($resultTempHum)) {
                $Cats .= "'" . date("d-m-Y H:i", substr ($rowTempHum["ts"], 0, 10)). "',";
                $Temp[] = $rowTempHum["t"];
                $Hum[] = $rowTempHum["h"];
                $LastTemp = $rowTempHum["t"];
                $LastHum = $rowTempHum["h"];
            }
        }
        // Eliminar las commas finales.
        $Cats = substr ($Cats, 0, -1);

        // Cerramos la base de datos
        $dbhandle->close();

        /* CÁLCULO DE LA SENSACIÓN TÉRMICA (TEMPERATURA APARENTE)
        # Definiciones:
        # Humedad Relativa (HR) = Pw/Pws * 100
        # Donde Pw es la presion de vapor de agua y
        # Pws es la Presion de la saturacion del vapor de agua
        # En este sentido Pw = HR/100 * Pws
        # Podemos averiguar Pws a traves de la temperatura seca con la formula
        # de la World Meteorological Organization (2008):
        # Pws = 6.112 * e^(17.62*t/(243.12 + t))
        # Siendo t la temperatura seca en ºC y Pws expresado en hPa
        # De este modo podemos calcular Pw desde la HR y la Temp.
        # https://www.eas.ualberta.ca/jdwilson/EAS372_13/Vomel_CIRES_satvpformulae.html

        # Desde la WMO: https://www.wmo.int/pages/prog/wcp/ccl/opace/opace4/meetings/documents/G_McGregorChallengeofClimateIndexforHealthsector.pdf 
        # Obtenemos la formula para calcular la Temperatura Aparente:
        # TA = t + 0.33 * Pw - 0.70 * ws - 4.00
        # Donde t es temperatura seca en ºC, Pw la presion de vapor de agua en hPa y
        # ws la velocidad del viento en m/s
        */
        
        // En primer lugar convertimos el viento de Km/h a m/s:
        $LastWindAvgms = $LastWindAvg * 0.27777777777778;
        $LastWindMaxms = $LastWindMax * 0.27777777777778;
        
        // Fórmula de Guide to Meteorological Instruments and Methods of Observation (CIMO Guide). (WMO 2008) [M_E = número e (2.7182818284590452354)]
        settype ($s, "float");
        settype ($Psw, "float");
        settype ($Pw, "float");
        settype ($atavg, "float");
        settype ($atmax, "float");
        $s = (17.62 * $LastTemp) / (243.12 + $LastTemp);
        $Pws = 6.112 * M_E ** $s;
        $Pw = $LastHum / 100 * $Pws;
        $atavg = $LastTemp + 0.33 * $Pw - 0.7 * $LastWindAvgms - 4.00; // Temperatura aparente teniendo en cuenta la velocidad máxima del viento
        $atmax = $LastTemp + 0.33 * $Pw - 0.7 * $LastWindMaxms - 4.00; // Temperatura aparente teniendo en cuenta la velocidad media del viento
        
        // Fórmulas para Cálculo del punto de rocío.
        // Existen varias fórmulas, inexactas ambas por no tener en cuenta la presión de la masa de aire,
        // Para realizar este cálculo:
        // 1.- Pr = (Raiz octava (H/100))*(110+T)-110
        // 2.- Pr = (Raiz octava (H/100))*(112+0.9*t)+(0.1*T)-112
        // 3.- Pr = T + 35*Log(HR)
        settype ($PR1, "float");
        settype ($PR2, "float");
        settype ($PR3, "float");
        $PR1 = (($LastHum/100)**0.125) * (110+$LastTemp)-110;
        $PR2 = (($LastHum/100)**0.125) * (112+0.9*$LastTemp)+(0.1*$LastTemp)-112;
        $PR3 = $LastTemp + 35 * log10($LastHum/100);
        // echo $PR1 . ' ' . $PR2 . ' ' . $PR3;
        
        /*TEMPERATURA DE SENSACIÓN O PERCIBIDA
        # FÓRMULA: Ts=13.12+0.6215*T-11.37*V**0.16 + 0.3965 * T * V**0.16
        # Dnde Ts es la temperatura de sensación en ºC, T la temperatura del aire y V la velocidad del viento en Km/h
        */
        settype ($Ts, "float");
        $Ts = 13.12 + 0.6215 * $LastTemp - 11.37 * $LastWindAvg ** 0.16 + 0.3965 * $LastTemp * $LastWindAvg ** 0.16;
        
        /* TEMPERATURA DE BOCHORNO
        # Basada en la humedad relativa y la temperatura actual: https://es.wikipedia.org/wiki/Temperatura_de_bochorno
        # Fórmula: TH (ºC) = T(ºC) + 5*((P-10)/9) Siendo la P la presión de vapor de agua atmosférica en hPa
        */
        settype ($TH, "float");
        $TH = $LastTemp + 5*(($Pws - 10)/9);
        
        // Fórmula para el cálculo de la altura de las nubes.
        // Basándonos en la temperatura y el punto de rocía
        settype ($HNubes, "float");
        $HNubes = 125 * ($LastTemp - $PR1);
        // echo $HNubes;
        ?>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body>
        <script src="./code/highcharts.js"></script>
        <script src="./code/highcharts-more.js"></script>
        <script type="text/javascript" src="./code/themes/grid-light.js"></script>
        <div id="Encabezado" style="width:100%; height: 200px; margin: 0 auto; position: relative; font-family: fantasy">
            <!-- <div id="Reloj" style="width: 200px; height: 200px; margin: 0 auto; float: left"></div> -->
            <!-- <div id="TempActual" style="width: 200px; height: 200px; float: left"></div> -->
            <!-- <div id="TempAparente" style="width: 200px; height: 200px; float: left"></div> -->
            Temperatura actual: <?php echo $LastTemp; ?>ºC <br />
            Humedad Relativa: <?php echo $LastHum; ?>%<br />
            Presión Atmosférica: <?php echo $LastPress; ?> hPa<br />
            Sensación Térmica: <?php echo /*$atavg;*/$Ts; ?>ºC <br />
            Temperatura de Bochorno: <?php echo $TH; ?>ºC <br />
            Punto de rocío: <?php echo $PR1; ?>ºC <br />
            Altura de las nubes: <?php echo $HNubes; ?>m <br />
            Velocidad media del viento: <?php echo $LastWindAvg; ?> Km/h <br />
            Rachas de viento: <?php echo $LastWindMax; ?> Km/h
        </div>
        <div id="Wind" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        <div id="TempHum" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        <div id="Pressure" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

        <!-- Configuración del gráfico del viento -->
        <script type="text/javascript">
            Highcharts.setOptions({
                // Cambia el Uso horario a la hora local
                global: {
                    useUTC: false
                }
            });
            var ranges = <?php echo $WindAll; ?>;
            Highcharts.chart('Wind', {
                chart: {
                    zoomType: 'x'
                },
                credits: {
                    enabled: false
                },
                title: {
                    text: 'Velocidad del viento. Última hora'
                },
                subtitle: {
                    text: 'Zona del Colegio Syalis. Los Pacos. Fuengirola'
                },
                xAxis: {
                    type: 'datetime',
                    labels: {
                        overflow: 'justify'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Velocidad (Km/h)'
                    },
                    min: 0,
                    minorGridLineWidth: 0,
                    gridLineWidth: 0,
                    alternateGridColor: null,
                    plotBands: [{ // Calma
                        from: 0,
                        to: 1,
                        color: 'rgba(0,0,0,0)',
                        label: {
                            text: 'Calma',
                            style: {
                                color: '#606060'
                            }
                        }
                    }, { // Ventolina
                        from: 1.1,
                        to: 5.5,
                        color: 'rgba(68, 170, 213, 0.1)',
                        label: {
                            text: 'Ventolina',
                            style: {
                                color: '#606060'
                            }
                        }
                    }, { // Light breeze
                        from: 5.6,
                        to: 11,
                        color: 'rgba(0, 0, 0, 0)',
                        label: {
                            text: 'Brisa Muy debil',
                            style: {
                                color: '#606060'
                            }
                        }
                    }, { // Gentle breeze
                        from: 12,
                        to: 19,
                        color: 'rgba(68, 170, 213, 0.1)',
                        label: {
                            text: 'Brisa Debil',
                            style: {
                                color: '#606060'
                            }
                        }
                    }, { // Moderate breeze
                        from: 20,
                        to: 28,
                        color: 'rgba(0, 0, 0, 0)',
                        label: {
                            text: 'Brisa moderada',
                            style: {
                                color: '#606060'
                            }
                        }
                    }, { // Fresh breeze
                        from: 29,
                        to: 38,
                        color: 'rgba(68, 170, 213, 0.1)',
                        label: {
                            text: 'Brisa fresca',
                            style: {
                                color: '#606060'
                            }
                        }
                    }, { // Strong breeze
                        from: 39,
                        to: 49,
                        color: 'rgba(0, 0, 0, 0)',
                        label: {
                            text: 'Brisa Fuerte',
                            style: {
                                color: '#606060'
                            }
                        }
                    }, { // High wind
                        from: 50,
                        to: 61,
                        color: 'rgba(68, 170, 213, 0.1)',
                        label: {
                            text: 'Viento fuerte',
                            style: {
                                color: '#606060'
                            }
                        }
                    }, { // Viento duro
                        from: 62,
                        to: 74,
                        color: 'rgba(0, 0, 0, 0)',
                        label: {
                            text: 'Temporal',
                            style: {
                                color: '#606060'
                            }
                        }
                    }, { // Viento muy duro
                        from: 75,
                        to: 88,
                        color: 'rgba(68, 170, 213, 0.1)',
                        label: {
                            text: 'Temporal fuerte',
                            style: {
                                color: '#606060'
                            }
                        }
                    }, { // Temporal duro
                        from: 89,
                        to: 102,
                        color: 'rgba(0, 0, 0, 0)',
                        label: {
                            text: 'Temporal duro',
                            style: {
                                color: '#606060'
                            }
                        }
                    }, { // Temporal muy duro
                        from: 103,
                        to: 117,
                        color: 'rgba(68, 170, 213, 0.1)',
                        label: {
                            text: 'Borrasca',
                            style: {
                                color: '#606060'
                            }
                        }
                    }, { // Temporal huracanado
                        from: 117,
                        color: 'rgba(0,0,0,0)',
                        label: {
                            text: 'Temporal huracanado',
                            style: {
                                color: '#606060'
                            }
                        }
                    }]
                },
                tooltip: {
                    valueSuffix: ' Km/h'
                },
                legend: {
                    layout: 'vertical',
                    align: 'left',
                    x: 160,
                    verticalAlign: 'top',
                    y:60,
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor)
                },
                plotOptions: {
                    spline: {
                        lineWidth: 1,
                        states: {
                            hover: {
                                lineWidth: 2
                            }
                        },
                        marker: {
                            enabled: false
                        }
                    }
                },
                series: [{
                    name: 'Velocidad Media',
                    data: averages,
                    type: 'spline',
                    zIndex: 1,
                    color:Highcharts.getOptions().colors[7],
                    marker: {
                        fillColor: 'white',
                        lineWidth: 4,
                        lineColor: Highcharts.getOptions().colors[7]
                }

                }, {
                    name: 'Rangos de velocidad',
                    data: ranges,
                    type: 'arearange',
                    lineWidth: 0,
                    LinkedTo: ':previous',
                    color:Highcharts.getOptions().colors[4],
                    fillOpacity: 0.5,
                    zIndex: 0
                }],
                navigation: {
                    menuItemStyle: {
                        fontSize: '10px'
                    }
                }
            });
		</script>

        <script type="text/javascript">
            Highcharts.chart('TempHum', {
                chart: {
                    zoomType: 'x'
                },
                credits: {
                    enabled: false
                },
                title: {
                    text: 'Temperatura y Humedad'
                },
                subtitle: {
                    text: 'Zona de los Pacos. Fuengirola'
                },
                xAxis: [{
                    type: 'datetime',
                    labels: {
                        overflow: 'justify'
                    },
                    categories:[<?php echo $Cats; ?>],
                    crosshair: true
                }],
                yAxis: [{ //Humedad Relativa
                    labels: {
                        format: '{value} %',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    },
                    title: {
                        text: 'Humedad Relativa',
                        style: {
                            color: Highcharts.getOptions().colors[0]
                        }
                    }
                }, { // Eje de Temperatura
                    title: {
                        text: 'Temperatura',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    labels: {
                        format: '{value}ºC',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    opposite: true
                }],
                tooltip: {
                    shared: true
                },
                legend: {
                    layout: 'vertical',
                    align: 'left',
                    x: 80,
                    verticalAlign: 'top',
                    y:10,
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor)
                },
                plotOptions: {
                    spline: {
                        lineWidth: 1,
                        states: {
                            hover: {
                                lineWidth: 2
                            }
                        },
                        marker: {
                            enabled: false
                        }
                    }
                },
                series: [{
                    name: 'Temperatura',
                    type: 'spline',
                    yAxis: 1,
                    color:Highcharts.getOptions().colors[1],
                    data: [<?php echo join ($Temp, ', '); ?>],
                    tooltip: {
                        valueSuffix: 'ºC'
                    }
                }, {
                    name: 'Humedad Relativa',
                    type: 'spline',
                    color:Highcharts.getOptions().colors[0],
                    data: [<?php echo join ($Hum, ', '); ?>],
                    dahStyle: 'shortdot',
                    tooltip: {
                        valueSuffix: '%'
                    }
                }]
            });
        </script>

        <!-- Configuración del gráfico de Presión Atmosférica -->
        <script type="text/javascript">
            Highcharts.chart('Pressure', {
                chart: {
                    type: 'spline',
                    zoomType: 'x'
                },
                credits: {
                    enabled: false
                },
                title: {
                    text: 'presión atmosférica'
                },
                subtitle: {
                    text: 'Variación de la presión atmosférica. Zona de los Pacos. Fuengirola'
                },
                xAxis: {
                    type: 'datetime',
                    labels: {
                        overflow: 'justify'
                    }
                },
                yAxis: {
                    title: {
                        text: 'hPa'
                    },
                    minorGridLineWidth: 0,
                    gridLineWidth: 1,
                    alternateGridColor: null,
                },
                tooltip: {
                    valueSuffix: ' hPa'
                },
                plotOptions: {
                    spline: {
                        lineWidth: 1,
                        states: {
                            hover: {
                                lineWidth: 2
                            }
                        },
                        marker: {
                            enabled: false
                        }
                    }
                },
                series: [{
                    name: 'Presión atmosférica',
                    data: [<?php echo $Press; ?>]

                }],
                navigation: {
                    menuItemStyle: {
                        fontSize: '10px'
                    }
                }
            });
        </script>

        <!-- Configuración del Reloj
        <script type="text/javascript">         

            /**
             * Get the current time
             */
            function getNow() {
                var now = new Date();

                return {
                    hours: now.getHours() + now.getMinutes() / 60,
                    minutes: now.getMinutes() * 12 / 60 + now.getSeconds() * 12 / 3600,
                    seconds: now.getSeconds() * 12 / 60
                };
            }

            /**
             * Pad numbers
             */
            function pad(number, length) {
                // Create an array of the remaining length + 1 and join it with 0's
                return new Array((length || 2) + 1 - String(number).length).join(0) + number;
            }

            var now = getNow();

            // Create the chart

            Highcharts.chart('Reloj', {

                chart: {
                    type: 'gauge',
                    plotBackgroundColor: null,
                    plotBackgroundImage: null,
                    plotBorderWidth: 0,
                    plotShadow: false,
                    height: 200
                },

                credits: {
                    enabled: false
                },

                title: {
                    text: 'Hora actual'
                },

                pane: {
                    background: [{
                        // default background
                    }, {
                        // reflex for supported browsers
                        backgroundColor: Highcharts.svg ? {
                            radialGradient: {
                                cx: 0.5,
                                cy: -0.4,
                                r: 1.9
                            },
                            stops: [
                                [0.5, 'rgba(255, 255, 255, 0.2)'],
                                [0.5, 'rgba(200, 200, 200, 0.2)']
                            ]
                        } : null
                    }]
                },

                yAxis: {
                    labels: {
                        distance: -20
                    },
                    min: 0,
                    max: 12,
                    lineWidth: 3,
                    showFirstLabel: false,
                    minorTickInterval: 'auto',
                    minorTickWidth: 1,
                    minorTickLength: 5,
                    minorTickPosition: 'inside',
                    minorGridLineWidth: 0,
                    minorTickColor: '#666',

                    tickInterval: 1,
                    tickWidth: 2,
                    tickPosition: 'inside',
                    tickLength: 10,
                    tickColor: '#666',
                    title: {
                        text: '',
                        style: {
                            color: '#BBB',
                            fontWeight: 'normal',
                            fontSize: '7px',
                            lineHeight: '10px'
                        },
                        y: 10
                    }
                },

                tooltip: {
                    formatter: function () {
                        return this.series.chart.tooltipText;
                    }
                },

                series: [{
                    data: [{
                        id: 'hour',
                        y: now.hours,
                        dial: {
                            radius: '60%',
                            baseWidth: 4,
                            baseLength: '95%',
                            rearLength: 0
                        }
                    }, {
                        id: 'minute',
                        y: now.minutes,
                        dial: {
                            baseLength: '95%',
                            rearLength: 0
                        }
                    }, {
                        id: 'second',
                        y: now.seconds,
                        dial: {
                            radius: '100%',
                            baseWidth: 1,
                            rearLength: '20%'
                        }
                    }],
                    exporting: {
                        enabled: false
                    },
                    animation: false,
                    dataLabels: {
                        enabled: false
                    }
                }]
            },
                // Move
                function (chart) {
                    setInterval(function () {

                        now = getNow();

                        if (chart.axes) { // not destroyed
                            var hour = chart.get('hour'),
                                minute = chart.get('minute'),
                                second = chart.get('second'),
                                // run animation unless we're wrapping around from 59 to 0
                                animation = now.seconds === 0 ?
                                    false : {
                                        easing: 'easeOutBounce'
                                    };

                            // Cache the tooltip text
                            chart.tooltipText =
                                pad(Math.floor(now.hours), 2) + ':' +
                                pad(Math.floor(now.minutes * 5), 2) + ':' +
                                pad(now.seconds * 5, 2);


                            hour.update(now.hours, true, animation);
                            minute.update(now.minutes, true, animation);
                            second.update(now.seconds, true, animation);
                        }

                    }, 1000);

                });
            /**
             * Easing function from https://github.com/danro/easing-js/blob/master/easing.js
             */
            Math.easeOutBounce = function (pos) {
                if ((pos) < (1 / 2.75)) {
                    return (7.5625 * pos * pos);
                }
                if (pos < (2 / 2.75)) {
                    return (7.5625 * (pos -= (1.5 / 2.75)) * pos + 0.75);
                }
                if (pos < (2.5 / 2.75)) {
                    return (7.5625 * (pos -= (2.25 / 2.75)) * pos + 0.9375);
                }
                return (7.5625 * (pos -= (2.625 / 2.75)) * pos + 0.984375);
            };
		</script>

//Reloj de temperatura actual
		<script type="text/javascript">
            Highcharts.chart('TempActual', {

                chart: {
                    type: 'gauge',
                    plotBackgroundColor: null,
                    plotBackgroundImage: null,
                    plotBorderWidth: 0,
                    plotShadow: false
                },
                title: {
                    text: 'Temperatura'
                },

                pane: {
                    startAngle: -150,
                    endAngle: 150,
                    background: [{
                        backgroundColor: {
                            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                            stops: [
                                [0, '#FFF'],
                                [1, '#333']
                            ]
                        },
                        borderWidth: 0,
                        outerRadius: '109%'
                    }, {
                        backgroundColor: {
                            linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                            stops: [
                                [0, '#333'],
                                [1, '#FFF']
                            ]
                        },
                        borderWidth: 1,
                        outerRadius: '100%'
                    }, {
                        // default background
                    }, {
                        backgroundColor: '#DDD',
                        borderWidth: 0,
                        outerRadius: '105%',
                        innerRadius: '103%'
                    }]
                },

                // the value axis
                yAxis: {
                    min: -10,
                    max: 50,

                    minorTickInterval: 'auto',
                    minorTickWidth: 1,
                    minorTickLength: 10,
                    minorTickPosition: 'inside',
                    minorTickColor: '#666',

                    tickPixelInterval: 30,
                    tickWidth: 2,
                    tickPosition: 'inside',
                    tickLength: 12,
                    tickColor: '#222',
                    labels: {
                        step: 2,
                        rotation: 'auto'
                    },
                    title: {
                        text: 'ºC'
                    },
                    plotBands: [{
                        from: -10,
                        to: 15,
                        color: '#553BBF' // blue
                    }, {
                        from: 15,
                        to: 30,
                        color: '#55BF3B' // green
                    }, {
                        from: 30,
                        to: 37,
                        color: '#DDDF0D' // yellow
                    }, {
                        from: 37,
                        to: 50,
                        color: '#DF5353' // red
                    }]
                },

                series: [{
                    name: 'Temperatura',
                    data: [<?php echo $LastTemp; ?>],
                    tooltip: {
                        valueSuffix: 'ºC'
                    }
                }]

            });
		</script> -->

    </body>
</html>

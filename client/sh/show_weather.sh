#!/bin/bash

PID=$(ps -ef | egrep "\bsudo python main.py\b" | awk '{print $2}')
if [ -z "$PID" ]; then
  echo "WeatherPi not running."
  exit 1
else
  echo "WheatherPi running with process number: $PID"
fi

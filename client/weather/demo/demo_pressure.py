import common
from demo_util import random_value


class Pressure:

  def get_sample(self):
    return 'press', (common.timestamp(), random_value(900, 1100))

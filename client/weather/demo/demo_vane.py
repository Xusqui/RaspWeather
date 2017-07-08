import common
from demo_util import random_value


class Direction:

  def get_sample(self):
    return 'vane', (common.timestamp(), random_value(0, 360))

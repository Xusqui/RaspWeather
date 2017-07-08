import common
from demo_util import random_value


class Rain:

  def get_sample(self):
    return 'rain', (common.timestamp(), random_value(0, 100))

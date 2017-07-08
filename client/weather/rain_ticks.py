import common
import threading


class Ticks:
  """Stores the timestamps of rain gauge revolutions."""

  def __init__(self):
    self._edges = 0
    self._lock = threading.RLock()  # re-entrant for use in calibration_add_edge_and_log

  def get_and_reset(self):
    """Return the number of edges and turns counter to 0."""
    with self._lock:
      ticks = self._edges
      self._edges = 0
    return ticks

  def add_edge(self, pin_ignored):
    """Count one edge."""
    with self._lock:
      self._edges = self._edges + 1  

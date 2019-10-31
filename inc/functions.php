<?php
function get_under_rests($mysqli, $rest_id) {
  $under_rests = array();
  $sql = "SELECT navn FROM under_rest WHERE rest_id = $rest_id ORDER BY navn ASC";
  $result = $mysqli->query($sql);

  while ($under_rest = $result->fetch_assoc())
    $under_rests[] = $under_rest['navn'];

  return $under_rests;
}
?>
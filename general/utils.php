<?php 
define('WEBROOT', '/var/www/html');
require WEBROOT.'/auth/db.php';

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
  ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

function generate_table($sql, $mysqli, $showID = false, $buttons = false) {
  // Connect to MySQL database    
  // Get column names of query result set
  $result = $mysqli->query($sql);
  $headers = array();
  while ($field_info = $result->fetch_field()) {
    if($field_info->name != 'id'){
      console_log($field_info->name);
      $headers[] = $field_info->name;
    }else{
      if($showID){
        $headers[] = $field_info->name;
      }
    }
  }
  $header_html = "";
  foreach ($headers as $header) {
      $header_html .= "<th>$header</th>";
  }
  
  // Generate table rows
  $row_html = "";
  while ($row = $result->fetch_assoc()) {
      $row_html .= "<tr data-table-id='". $row['id'] ."'>";
      foreach ($headers as $header) {
          $row_html .= "<td>" . $row[$header] . "</td>";
      }
      if($buttons){
          $row_html .= '<td>
                          <div class="buttons">
                              '.$buttons.'
                          </div>
                      </td>';
      }
      $row_html .= '</tr>';
  }
  
  // Generate complete HTML table
  $table_html = "<table>
                      <thead>
                          <tr>$header_html";

  if($buttons){
      $table_html .= '<th>Actions</th>';
  }
  $table_html .= '</tr>
                      </thead>
                      <tbody>'.$row_html.'</tbody>
                  </table>';
  
  // Output table HTML
  echo $table_html;
}

function generate_action_button($name, $direct, $icon){
  $button = '<button class="button action-button '.$name.'" data-url="'.$direct.'">
                  <i class="fa-solid '. $icon .'"></i>
              </button>';
  return $button;
}
?>

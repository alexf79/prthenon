<?php
class CurlBrowser {
  public static $nextsessionId = 0;
  var $content;  
  var $options = array(
    'header'         => true,
    'followlocation' => true,
    'returntransfer' => true,
    'ssl_verifyhost' => false,
    'ssl_verifypeer' => false,    
    'useragent'      => 'Mozilla/5.0 (Windows NT 6.1; rv:18.0) Gecko/20100101 Firefox/18.0'    
  );
  var $cookieStorage;

  function get($url) {
    //$this->options['header'] = true;
    unset($this->options['post']);
    $this->options['httpget'] = true;    
    return $this->fetch($url);           
  }

  function post($url, $data) {    
    unset($this->options['httpget']);
    $this->options['post'] = true;
    if(!empty($data)) $this->options['postfields'] = $data;
    return $this->fetch($url);    
  }

  function download($url, $filePath) {
    $this->options['binarytransfer'] = true;
    $this->fetch($url);
    if(file_exists($filePath)) unlink($filePath);
    $fp = fopen($filePath, 'x');
    $status = fwrite($fp, $this->content);
    fclose($fp);
    return $status;
  }

  function fetch($url) {
    $ch = curl_init($url);
    $this->configCookies();
    $this->configCurl($ch);
    $this->content = curl_exec($ch);
    curl_close($ch);
    return $this->content;
  }

  function configCookies() {
    /*if(empty($this->cookieStorage)) {
      $this->cookieStorage = dirname(__FILE__)."/cookies".$_SESSION["sessionId"].".txt";
      exec("touch $this->cookieStorage");
    }
    $this->options['cookiefile'] = $this->cookieStorage;
    $this->options['cookiejar']  = $this->cookieStorage;    */
  }

  function configCurl($ch) {
    foreach($this->options as $option => $value)
      curl_setopt($ch, constant('CURLOPT_'.strtoupper($option)), $value);
  }

  function readCookies() {
    $content = file_get_contents($this->cookieStorage);
    foreach(explode("\n", $content) as $line) {
      if(isset($line[0]) and substr_count($line, "\t") == 6) {
        $cookieData = explode("\t", $line);
        $cookieData = array_map('trim', $cookieData);
        $this->cookies[$cookieData[5]] = $cookieData[6];
      }
    }
  }

  function __destruct() { //unlink($this->cookieStorage); 
  }
}
?>
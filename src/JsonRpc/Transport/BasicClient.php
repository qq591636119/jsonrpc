<?php
namespace JsonRpc\Transport;


class BasicClient
{

  public $output = '';
  public $error = '';


  public function send($method, $uri, $json, $headers = array())
  {

    $header = 'Content-Type: application/json';

    if (!in_array($header, $headers))
    {
      $headers[] = $header;
    }

    $opts = array(
      'http' => array(
        'method' => $method,
        'header' => implode("\r\n", $headers),
        'content' => $json,
      )
    );

    $context = stream_context_create($opts);
    $response = @file_get_contents($uri, false, $context);

    if ($response === false)
    {
      $this->error = 'Unable to connect to ' . $uri;
      return;
    }

    $this->output = $response;

    return true;

  }

}


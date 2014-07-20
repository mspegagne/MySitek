<?php
require_once("lib/Payplug.php");
Payplug::setConfigFromFile("parameters.json");

$paymentUrl = PaymentUrl::generateUrl(array(
                                      'amount' => 5000,
                                      'currency' => 'EUR',
                                      'ipnUrl' => 'http://www.example.org/ipn.php',
                                      'email' => '', /* Your customer mail address */
                                      'firstName' => '',
                                      'lastName' => ''
                                      ));
header("Location: $paymentUrl");
exit();

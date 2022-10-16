<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Thermal PrinterConfig
|--------------------------------------------------------------------------
|
*/
//Enable thermal_printer  Value TRUE/FALSE
$config['thermal_print_enable'] = FALSE;

/*
 |--------------------------------------------------------------------------------------------------
Printer Connection

To print receipts from PHP, use the most applicable PrintConnector for
 your setup. The connector simply provides the plumbing to get data to the printer.
Values =>
For FilePrintConnector =  'file'
NetworkPrintConnector = 'network'
WindowsPrintConnector (USB) = 'windows'
DummyPrintConnector = 'test'
|--------------------------------------------------------------------------------------------------
 */
$config['printer_connection'] = 'test';

/*
  |   Connector Value

For Windows // Enter the share name for your USB/LPT1 printer here

For Network

/* Most printers are open on port 9100, so you just need to know the IP
 * address of your receipt printer, and then fsockopen() it on that port.
 */
//
//Applicable only for For FilePrintConnector
$config['print_file'] = '/dev/usb/lp0';

//Applicable only for For NetworkPrintConnector
$config['print_network'] = array("10.x.x.x", 9100);

//Applicable only for For windows
$config['print_windows'] = 'LPT1';


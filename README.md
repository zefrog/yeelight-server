# Simple Yeelight local server

## Installation
Install this project on a local webserver supporting PHP to be able to control locally availables Yeelight RGB LED products.

You will need to enable developer mode on each product using the Yeelight official app to discover your devices.

Configure your settings in the `api/config.php` file, notably the network interface used to connect to the local network.

## Usage
It uses the discovery protocol described in the developer manual:
http://www.yeelight.com/download/Yeelight_Inter-Operation_Spec.pdf

Using manually the `set_name` function will allow you to set the displayed name of your product. For some reason the name you set in the official app does not apply to the developer mode.

The web interface is designed to be used with a smartphone, it also works on desktop. The implementation focuses only on RGB mode, using bootstrap, bootstrap-colorpicker and bootstrap-toggle.

## Thanks
Thanks to the jquery and bootstrap teams, bootstrap-colorpicker and bootstrap-toggle developers that allowed me to build this little tool.


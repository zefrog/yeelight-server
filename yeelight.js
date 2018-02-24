
var Yeelight = function(bulb, container) {
  this.bulb = bulb;
  this.container = container;
  this.timeout = null;
  this.status = "off";

//  $('<h1 class=title></h1>').text(this.bulb.name).appendTo(this.container);
  var commands = $('<div class="commands"></div>').appendTo(this.container);

  var that = this;
  this.toggle = $('<input' + (bulb.power === 'on' ? ' checked' : '' ) +'>')
            .attr('type', 'checkbox')
            .attr('id', 'toggle')
            .appendTo(commands)
            .bootstrapToggle({
              width: 125,
              height: 40
            })
            .change(function() {
              $(this).prop('checked') ? that.turnOn() : that.turnOff();
            });
            console.log(this.toggle);
  $('<div class="colorpicker"></div>').appendTo(this.container).colorpicker({
        color: (parseInt(bulb.rgb).toString(16)),
        container: true,
        inline: true,
        hexNumberSignPrefix: false,
        sliders: { saturation: { maxLeft: 320, maxTop: 320 }, hue: { maxTop: 320 }, alpha: { maxTop: 320 } }
    }).on('changeColor', function(e) {
      // determine event color & brightness
      var color = parseInt(e.color.toString(), 16),
              brightness = parseInt(e.color.value.b*100)
      ;
      // delay update if there was an update less than a second ago
      if (that.timeout) {
        clearTimeout(that.timeout);
        that.timeout = setTimeout(function() {
          that.updateColor(color, brightness);
        }, 1500);
      } else {
        that.updateColor(color, brightness);
      }
    });

    this.pstatus = $('<p class="status"></p>').appendTo(this.container);
    this.updateStatus(parseInt(this.bulb.rgb), this.bulb.bright);
};

  // update color, mark color changed less than a second ago
Yeelight.prototype.updateColor = function(color, brightness) {
    $.post({
      url: 'api/send.php',
      data: {
        ip: this.bulb.ip,
        method: 'set_scene',
        params: ['color', color, brightness]
      }
    });
    this.updateStatus(color, brightness);
    // timeout says color was changed less than a second ago
    var that = this;
    this.timeout = window.setTimeout(function() {
      that.timeout = null;
    }, 1500);
  };

  // power on
Yeelight.prototype.turnOn = function() {
    $.post({
      url: 'api/send.php',
      data: {
        ip: this.bulb.ip,
        method: "set_power",
        params: ['on']
      }
    });
  };

  // power off
Yeelight.prototype.turnOff = function() {
    $.post({
      url: 'api/send.php',
      data: {
        ip: this.bulb.ip,
        method: "set_power",
        params: ['off']
      }
    });
  };

Yeelight.prototype.updateStatus = function(color, brightness) {
    this.pstatus.text("#" + color.toString(16).toUpperCase() + " / " + brightness + "%");
};

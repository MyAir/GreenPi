
var GrovePi = require('node-grovepi').GrovePi
var SPDTRelay = require('./sensors/SPDTRelay');
// var i2cbus = require('./node_modules/node-grovepi/node_modules/i2c-bus/i2c-bus');
// var Commands = GrovePi.commands
// var Board = GrovePi.board
var MyRelay = GrovePi.sensors.SPDTRelay
// var DHTDigitalSensor = GrovePi.sensors.DHTDigital
var relais
//this function sends and receives the pin's status
function change_pin (pin, status) {
        console.log("Start change_pin")

  // board = new Board({
  //   debug: true,
  //   onError: function(err) {
  //     console.log('TEST ERROR')
  //     console.log(err)
  //   },
  //   onInit: function(res) {
  //     if (res) {
  //       console.log('GrovePi Version :: ' + board.version())
  //     } else {
  //       console.log('TEST CANNOT START')
  //     }
  //   }
  // })
  // board.init()
  
  if ( (!isNaN(pin)) && (!isNaN(status)) && (pin <= 7) && (pin >= 0) && (status == "0") || (status == "1") ) {
	//set the gpio's mode to output		
    // 	system("gpio mode ".$pin." out")
    // Commands.pinMode(pin,"OUTPUT")
    
    console.log("pin="+pin)
    // var board = new Board
    // var dhtSensor = new DHTDigitalSensor(7, DHTDigitalSensor.VERSION.DHT11, DHTDigitalSensor.CELSIUS)
    // var relais = new SPDTRelay(pin)
    relais = new MyRelay(pin)
	//set the gpio to high/low
	if (status == "0" ) { status = "1" }
	else if (status == "1" ) { status = "0" }
    
        // 	system("gpio write ".$pin." ".$status )
        // Commands.digitalWrite(pin,status)
        if(status == "1"){relais.on} else {relais.off}
        //reading pin's status
        // exec ("gpio read ".$pin, $status, $return )
        // var stat = Commands.digitalRead(pin,status)
        //printing it
        // return (status)
        // return(parseInt(status))
        return 0
    } //print fail if cannot use values
    else { 
        alert ("server error")
        console.log("Error first IF")
        return ("fail") 
        
    }
}

var stat = 0
var ret= change_pin(2,stat)
console.log(ret, stat)
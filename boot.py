import machine
import onewire
import ds18x20
import time
import urequests as requests

def do_connect():
    import network
    sta_if = network.WLAN(network.STA_IF)
    if not sta_if.isconnected():
        print('connecting to network...')
        sta_if.active(True)
        sta_if.connect('username', 'password')
        while not sta_if.isconnected():
            pass
    print('network configuration:\n', sta_if.ifconfig(), '\n')
    
led = machine.Pin(13, machine.Pin.OUT)
ow_bus = onewire.OneWire(machine.Pin(27))   #Init wire
ow_bus.scan()
ds18=ds18x20.DS18X20(ow_bus)          #create ds18x20 object

                  
def checkTemp():
  roms=ds18.scan()                #scan ds18x20
  ds18.convert_temp()             #convert temperature
  for rom in roms:
    global temp
    temp = (ds18.read_temp(rom))    #display
    
def postRequest():
    try:
        url = 'https://joebohack.com/temperature/log/?temperature=' + temperature
        r = requests.post(url)
        print(r.text + "temperature logged ~", temperature, "F")
    except Exception as postError:
        print("Posting error:", postError)
        print("retrying...")
        time.sleep(5)
        do_connect()
        postRequest()
    
while True:
    led.on()
    do_connect()
    checkTemp()
    temperature = str(9/5 * temp + 32)
    postRequest()    
    led.off()
    time.sleep(300)



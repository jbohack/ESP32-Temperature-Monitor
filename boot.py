import machine
import onewire
import ds18x20
import time
import urequests as requests
import network

wifi_ssid = "ssid"
wifi_password = "password"

def do_connect(ssid, pwd, hard_reset=True):
    interface = network.WLAN(network.STA_IF)

    if not pwd or not ssid :
        print('no ssid or password given')
        interface.active(False)
        return None

    for t in range(0, 120):
        if interface.isconnected():
            print('network configuration:\n', interface.ifconfig(), '\n')
            return interface
        time.sleep_ms(200)

        if t == 60 and hard_reset:
            interface.active(True)
            interface.connect(ssid, pwd)

    print('Cant connect to ', ssid)
    return None
    
led = machine.Pin(13, machine.Pin.OUT)
ow_bus = onewire.OneWire(machine.Pin(27))   #Init wire
ow_bus.scan()
ds18=ds18x20.DS18X20(ow_bus)          #create ds18x20 object

                  
def checkTemp():
    try:
        roms=ds18.scan()                #scan ds18x20
        ds18.convert_temp()             #convert temperature
        for rom in roms:
            global temp
            temp = (ds18.read_temp(rom))    #display
    except Exception as temperatureReadError:
        print("Temperature reading error:", temperatureReadError)
        print("retrying...")
        time.sleep(5)
        checkTemp()
    
def postRequest():
    try:
        url = 'https://joebohack.com/temperature/log/?temperature=' + temperature
        r = requests.post(url)
        print(r.text + "temperature logged ~", temperature, "F")
    except Exception as postError:
        print("Posting error:", postError)
        print("retrying...")
        time.sleep(5)
        do_connect(wifi_ssid, wifi_password)
        postRequest()
    
while True:
    led.on()
    do_connect(wifi_ssid, wifi_password)
    checkTemp()
    time.sleep(0.5)
    temperature = str(9/5 * temp + 32)
    postRequest()    
    led.off()
    time.sleep(300)
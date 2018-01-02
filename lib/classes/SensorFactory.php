<?php
/*
 * @author Bhashithe Abeysinghe
 */

class SensorFactory {
    public function getSensorObject($type) {
        
        if($type==Sensor::PRESSURE)
        {
            return new PressureSensor();
        }
        else if($type==Sensor::TEMPERATURE)
        {
            return new TemperatureSensor();
        }
        else if($type==Sensor::HUMIDITY)
        {
            return new HumiditySensor();
        }
    }
    
    public function getSensorObjectWithId($type, $id) 
    {
        if($type==Sensor::PRESSURE)
        {
            return new PressureSensor($id);
        }
        else if($type==Sensor::TEMPERATURE)
        {
            return new TemperatureSensor($id);
        }
        else if($type==Sensor::HUMIDITY)
        {
            return new HumiditySensor($id);
        }
    }
}

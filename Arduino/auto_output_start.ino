// ORCHARD'S DIGITAL SCALE READINGS



#include <HX711.h>                            // HX-711 library
HX711 scale(A1, A0);                          // HX711.DOUT	- pin #A1
                                              // HX711.PD_SCK	- pin #A0
int countdown;                   
int reset_countdown;
int p;
char message;
int delta;
int delta2 = 0;

// End of variable declarations.


void setup() 
  
  {  
  Serial.begin(38400);
  scale.set_scale(20.0);                      
  scale.tare();				     
  }

// End of setup function.


void loop() 
  
  {
  
  Serial.begin(38400); 
  Serial.print(scale.get_units(), 1); 
  delta = (scale.get_units()); 
  Serial.print("\t\t"); 
  Serial.println(delta - delta2); 
  delta2 = delta;
  scale.power_down();
  delay(5000);
  scale.power_up();
  countdown = countdown - 1;
          
          Serial.end();
          Serial.begin(38400);
          char message; 
  
        
  
      if (message == 'r') 
        {  

          Serial.println("RESETTING"); 
          delay(500); 
          software_Reset();
        
        }

    }

 

// End of loop function.


void software_Reset()
  
  {
    asm volatile ("  jmp 0");
  }

// End of program.


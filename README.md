# epush
Simple PHP class sending notification to Android devices.


Example:

        $epush = new Epush();
        $epush->apiKey('Server Api Key');
        $epush->devices( array('regIdX', 'regIdY', 'regIdZ') ); // or just one device $epush->devices('regIdX');
        
        $epush->title( 'Simple Title' );
        $epush->subTitle( 'Simple Title' );
        $epush->message( 'Simple Message' );
        $epush->tickerText('Simple Ticker Text');
        $epush->vibrate(FALSE);
        $epush->sound(FALSE);
        
        // Open Debug Mode
        // $epush->debugMode(TRUE);
        
        echo $epush->send() ? 'Yepp!' : 'OMG! Why me?';

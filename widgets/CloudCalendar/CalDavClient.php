<?php
/**
 *  * Created by PhpStorm.
 * User: Philipp Dippel Inf | DMS - M
 * For Project: jWidget
 * Date: 26.06.17
 * Copyright: Philipp Dippel
 */


namespace dippel_rocks;
require_once('key.php');

class CalDavClient
{
    private $port;
    private $user;
    private $password;
    private $ch;

    //
    public function __construct()
    {

        $this->user = (string)USERNAME;
        $this->password = (string)CLOUDPASSWORD;

        $this->hostKlausren = 'https://cloud.fsi.hochschule-trier.de/remote.php/caldav/calendars/' . USERNAME . '/klausurplan_shared_by_dippelp';
        $this->hostFSI = 'https://cloud.fsi.hochschule-trier.de/remote.php/caldav/calendars/' . USERNAME . '/fachschaftsrat_shared_by_root';
        $this->port = 443;

        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/xml',
            'Depth: 1',
            'Prefer: return-minimal'
        ));

        //curl_setopt($this->ch, CURLOPT_URL, 'https://cloud.fsi.hochschule-trier.de/remote.php/caldav/calendars/dippelp/pers%C3%B6nlich');
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_PORT, $this->port);
        curl_setopt($this->ch, CURLOPT_USERPWD, $this->user . ':' . $this->password);
        curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

    }

    public function getInfos($label)
    {

        if ($label == 'klausur') {
            curl_setopt($this->ch, CURLOPT_URL, $this->hostKlausren);
        } else {
            curl_setopt($this->ch, CURLOPT_URL, $this->hostFSI);
        }

        $today = date("Ymd");

        $xml_datas = '<C:calendar-query xmlns:D=\'DAV:\'
                 xmlns:C=\'urn:ietf:params:xml:ns:caldav\'>
                                     <D:prop>
                                       <D:getetag/>
                                       <C:calendar-data>
                                         <C:comp name=\'VCALENDAR\'>
                                           <C:prop name=\'VERSION\'/>
                                           <C:comp name=\'VEVENT\'>
                                             <C:prop name=\'SUMMARY\'/>
                                             <C:prop name=\'DESCRIPTION\'/>
                                             <C:prop name=\'STATUS\'/>
                                              <C:prop name=\'TRANSP\'/>
                                               <C:prop name=\'ATTENDEE\'/>
                                             <C:prop name=\'UID\'/>
                                             <C:prop name=\'DTSTART\'/>
                                             <C:prop name=\'DTEND\'/>
                                             <C:prop name=\'DURATION\'/>
                                           </C:comp>
                                         </C:comp>
                                       </C:calendar-data>
                                     </D:prop>
                                     <C:filter>
       <C:comp-filter name=\'VCALENDAR\'>
         <C:comp-filter name=\'VEVENT\'>
           <C:time-range start=\'' . $today . 'T000000\'
                         end=\'25000101T000000\'/>
         </C:comp-filter>
       </C:comp-filter>
     </C:filter>
     </C:calendar-query>';

        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $xml_datas);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, "REPORT");

        $response = curl_exec($this->ch);
        $oXML = simplexml_load_string($response);
        $path = $oXML->xpath('//cal:calendar-data');

        $array = array();

        foreach ($path as $title) {
            array_push($array, $title);
        }

        foreach ($array as &$element) {
            //Bitte ab hier den Code nicht mehr beachten :D
            $fileContents = str_replace(array("\n", "\r", "\t"), ',', $element);
            $fileContents = preg_replace("~[^{:,]+~", '"${0}"', $fileContents);
            $fileContents = preg_replace('~"Event":"~', '"Event', $fileContents);
            $fileContents = preg_replace('~:,~', ':"",', $fileContents);
            $fileContents = preg_replace('~http":"~', 'http:', $fileContents);
            $fileContents = '{' . substr($fileContents, 0, -1) . '}';
            $element = $fileContents;

        }
        unset($element);

        return json_encode($array);
    }
}
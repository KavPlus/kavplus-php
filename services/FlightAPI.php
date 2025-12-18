<?php
class FlightAPI {

  const USE_LIVE_API = false; // ← switch to true when keys added

  public static function getFlightById($id, $search){
    if(self::USE_LIVE_API){
      // Amadeus / Sabre / Travelport call goes here
      // return self::fetchFromAmadeus($id, $search);
    }
    return self::mockFlight($id, $search);
  }

  private static function mockFlight($id, $search){
    return [
      "id"=>$id,
      "airline"=>"Emirates",
      "from"=>$search['from'],
      "to"=>$search['to'],
      "depart"=>"08:45",
      "arrive"=>"14:10",
      "stops"=>"Non-stop",
      "fareFamilies"=>[
        "Basic"=>[
          "price"=>699,
          "baggage"=>["cabin"=>"7kg","checkin"=>"15kg"],
          "refundable"=>false,
          "refundTimeline"=>[
            ["label"=>"Non-refundable","date"=>null]
          ]
        ],
        "Flex"=>[
          "price"=>759,
          "baggage"=>["cabin"=>"7kg","checkin"=>"25kg"],
          "refundable"=>true,
          "refundTimeline"=>[
            ["label"=>"Free cancellation","date"=>"+3 days"],
            ["label"=>"Partial refund","date"=>"+7 days"]
          ]
        ],
        "Plus"=>[
          "price"=>829,
          "baggage"=>["cabin"=>"10kg","checkin"=>"35kg"],
          "refundable"=>true,
          "refundTimeline"=>[
            ["label"=>"Free cancellation","date"=>"+5 days"],
            ["label"=>"Partial refund","date"=>"+10 days"]
          ]
        ]
      ],
      "seatMap"=>[
        "Economy"=>["A","B","C","D","E","F"],
        "rows"=>20
      ]
    ];
  }
}

<?php
namespace Pressmind\Travelshop;

use \Datetime;


class CalendarGenerator
{
    /**
     * Day Labels
     * @var array
     */
    private $DayLabels = array('Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So');

    /**
     * Month Labels
     * @var array
     */
    private $MonthLabels = array('Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember');

    /**
     * @var $CurrentDate
     */
    protected $CurrentDate;

    /**
     * @var $CurrentDateRange
     */
    protected $CurrentDateRange;

    /**
     * @var
     */
    protected $CurrentDateRangeObject;

    /**
     * @var $MinDate
     */
    protected $MinDate;

    /**
     * @var $MaxDate
     */
    protected $MaxDate;

    /**
     * @var $MinYear
     */
    protected $MinYear;

    /**
     * @var $MaxYear
     */
    protected $MaxYear;

    /**
     * @var $DepartureDates
     */
    protected $DepartureDates;

    /**
     * @var $CurrentDateString
     */
    protected $CurrentDateString;

    /**
     * @param $CurrentDate
     * @param $CurrentDateRange
     * @param $MinDate
     * @param $MaxDate
     * @param $MinYear
     * @param $MaxYear
     * @param $DepartureDates
     */
    public function __construct(
        $CurrentDate,
        $CurrentDateRange,
        $MinDate,
        $MaxDate,
        $MinYear,
        $MaxYear,
        $DepartureDates
    )
    {
        /**
         * Set variables with construct
         */
        $this->CurrentDate = $CurrentDate;
        $this->CurrentDateRange = $CurrentDateRange;
        $this->CurrentDateString = $CurrentDate->format('Y-m-d');
        $this->MinDate = !empty($MinDate) ? $MinDate : $CurrentDate->format('d.m.Y');
        $this->MinYear = !empty($MinYear) ? $MinYear : $CurrentDate->format('Y');
        $NextYear = $CurrentDate->add(new \DateInterval('P1Y'));
        $this->MaxDate = !empty($MaxDate) ? $MaxDate : $NextYear->format('d.m.Y');
        $this->MaxYear = !empty($MaxYear) ? $MaxYear : $NextYear->format('Y');
        $this->DepartureDates = json_decode($DepartureDates);

        $this->CurrentDateRangeObject = !empty($CurrentDateRange) ? $this->currentDateRangeModifier($CurrentDateRange) : null;
    }

    public function currentDateRangeModifier($CurrentDateRange) {
        $CurrentDateRangeObjectReturn = [];

        $CurrentDateRangeObject = explode('-', $CurrentDateRange);

        foreach ( $CurrentDateRangeObject as $Date ) {
            $DateTimestamp = strtotime($Date);
            $DateString = date('d-m-Y', $DateTimestamp);
            $DateStringObject = explode('-', $DateString);

            $DateObject = [
                'clear' => (int) $Date,
                'd' => (int) $DateStringObject[0],
                'm' => (int) $DateStringObject[1],
                'y' => (int) $DateStringObject[2],
            ];

            $CurrentDateRangeObjectReturn[] = $DateObject;
        }

        return $CurrentDateRangeObjectReturn;
    }

    public function getCalendarObject() {

        $CalendarReturn = [];

        $CalendarYears = range((int) $this->MinYear, (int) $this->MaxYear);
        $CalendarMinDate = strtotime($this->MinDate);
        $CalendarMaxDate = strtotime($this->MaxDate);

        $CalendarMinMonth = (int) date('m', $CalendarMinDate);
        $CalendarMaxMonth = (int) date('m', $CalendarMaxDate);

        $CalendarMinDay = (int) date('d', $CalendarMinDate);
        $CalendarMaxDay = (int) date('d', $CalendarMaxDate);

        foreach ( $CalendarYears as $Year ) {
            $IsMinYear = ( (int) date('Y', $CalendarMinDate) === $Year) ? true : false;
            $IsMaxYear = ( (int) date('Y', $CalendarMaxDate) === $Year) ? true : false;

            $GetMonthsAll = range(1, 12);
            $GetMonths = $GetMonthsAll;

            if ( $IsMinYear) {
                $GetMonths = range($CalendarMinMonth, 12);
            }

            if ( $IsMaxYear) {
                $GetMonths = range(1, $CalendarMaxMonth);
            }

            $Months = $this->getMonths($Year, $GetMonths, $CalendarMinMonth, $CalendarMaxMonth, $IsMinYear, $IsMaxYear, $CalendarMinDay, $CalendarMaxDay);

            $CalendarReturn[] = $Months;
        }

        return $CalendarReturn;
    }

    public function getMonths($Year, $Months, $MinMonth, $MaxMonth, $MinYear, $MaxYear, $MinDay, $MaxDay) {
        $MonthObject = [];

        foreach ( $Months as $Month ) {
            $MonthObject[$Month] = [];

            $MonthObject[$Month]['month'] = $Month;
            $MonthObject[$Month]['title'] = $this->MonthLabels[$Month - 1];
            $MonthObject[$Month]['daysHeader'] = $this->DayLabels;

            $DaysObject = [];

            $DateTimeMonth = ( $Month < 10 ) ? '0' . strval($Month) : strval($Month);
            $CountDays = (new \DateTime(strval($Year) . $DateTimeMonth . '01'))->format('t');

            $Days = range(1, (int)$CountDays);

            foreach ( $Days as $Day ) {
                $Interactive = true;

                $RangeStart = false;
                $RangeEnd = false;
                $RangeBetween = false;

                if ( $MinYear && ((int) $Day < (int) $MinDay && (int) $Month === (int) $MinMonth) ) {
                    $Interactive = false;
                }

                if ( $MaxYear && ((int) $Day > (int) $MaxDay && (int) $Month === (int) $MaxMonth) ) {
                    $Interactive = false;
                }

                $DateTimeDay = ( $Day < 10 ) ? '0' . strval($Day) : strval($Day);
                $DateString = (new \DateTime(strval($Year) . $DateTimeMonth . $DateTimeDay))->format('Y-m-d');
                $DateStringInteger = (int) (new \DateTime(strval($Year) . $DateTimeMonth . $DateTimeDay))->format('Ymd');

                $Current = (($this->CurrentDateString === $DateString) && empty($this->CurrentDateRange)) ? true : false;
                $Departure = in_array($DateString, $this->DepartureDates) ? true : false;

                // -- set range
                if ( !empty($this->CurrentDateRange) && $this->CurrentDateRangeObject !== null ) {
                    // range start
                    if (
                        !empty($this->CurrentDateRangeObject[0]) &&
                        (int) $Year === (int) $this->CurrentDateRangeObject[0]['y'] &&
                        (int) $Month === (int) $this->CurrentDateRangeObject[0]['m'] &&
                        (int) $Day === (int) $this->CurrentDateRangeObject[0]['d']
                    ) {
                        $RangeStart = true;
                    }

                    // range end
                    if (
                        !empty($this->CurrentDateRangeObject[1]) &&
                        (int) $Year === (int) $this->CurrentDateRangeObject[1]['y'] &&
                        (int) $Month === (int) $this->CurrentDateRangeObject[1]['m'] &&
                        (int) $Day === (int) $this->CurrentDateRangeObject[1]['d']
                    ) {
                        $RangeEnd = true;
                    }

                    // between
                    if (
                        (
                            !empty($this->CurrentDateRangeObject[1]) &&
                            !empty($this->CurrentDateRangeObject[0])
                        ) &&
                        (
                            (int) $DateStringInteger >= $this->CurrentDateRangeObject[0]['clear'] &&
                            (int) $DateStringInteger <= $this->CurrentDateRangeObject[1]['clear']
                        )
                    ) {
                        $RangeBetween = true;
                    }
                }

                $DaysObject[] = [
                    'day' => $Day,
                    'dayNumber' => (new \DateTime(strval($Year) . $DateTimeMonth . $DateTimeDay))->format('N'),
                    'date' => $DateString,
                    'interactive' => $Interactive,
                    'current' => $Current,
                    'departure' => $Departure,
                    'rangeStart' => $RangeStart,
                    'rangeEnd' => $RangeEnd,
                    'rangeBetween' => $RangeBetween
                ];
            }

            $MonthObject[$Month]['days'] = $DaysObject;

        }

        return $MonthObject;
    }
}
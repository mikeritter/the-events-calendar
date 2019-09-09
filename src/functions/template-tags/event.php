<?php
/**
 * Functions and template tags dedicated to Events.
 *
 * @since 4.9.7
 */

use Tribe\Events\Models\Post_Types\Event;
use Tribe\Utils\Lazy_Collection;
use Tribe\Utils\Lazy_String;
use Tribe\Utils\Post_Thumbnail;

if ( ! function_exists( 'tribe_get_event' ) ) {
	/**
	 * Fetches and returns a decorated post object representing an Event.
	 *
	 * @since 4.9.7
	 *
	 * @param null|int|WP_Post $event  The event ID or post object or `null` to use the global one.
	 * @param string|null      $output The required return type. One of `OBJECT`, `ARRAY_A`, or `ARRAY_N`, which
	 *                                 correspond to a WP_Post object, an associative array, or a numeric array,
	 *                                 respectively. Defaults to `OBJECT`.
	 * @param string           $filter Type of filter to apply. Accepts 'raw', a valid date string or
	 *                                 object to localize the event in a specific time-frame.
	 *
	 * @return array|mixed|void|WP_Post|null {
	 *                              The Event post object or array, `null` if not found.
	 *
	 *                              @type string $start_date The event start date, in `Y-m-d H:i:s` format.
	 *                              @type string $start_date_utc The event UTC start date, in `Y-m-d H:i:s` format.
	 *                              @type string $end_date The event end date, in `Y-m-d H:i:s` format.
	 *                              @type string $end_date_utc The event UTC end date, in `Y-m-d H:i:s` format.
	 *                              @type array $dates An array containing the event.start, end and UTC date objects. {
	 *                                              @type DateTimeImmutable $start The event start date object.
	 *                                              @type DateTimeImmutable $start_utc The event UTC start date object.
	 *                                              @type DateTimeImmutable $end The event end date object.
	 *                                              @type DateTimeImmutable $end_utc The event UTC end date object.
	 *                                          }
	 *                              @type string $timezone The event timezone string.
	 *                              @type int $duration The event duration in seconds.
	 *                              @type false|int $multiday Whether the event is multi-day or not and its day.
	 *                                                        duration if it is.
	 *                              @type bool $all_day Whether the event is an all-day one or not.
	 *                              @type null|bool $starts_this_week Whether the event starts on the week of the date
	 *                                                                specified in the `$filter` argument or not, `null`
	 *                                                                if no date is specified in the filter.
	 *                              @type null|bool $ends_this_week Whether the event ends on the week of the date
	 *                                                              specified in the `$filter` argument or not, `null`
	 *                                                              if no date is specified in the filter.
	 *                              @type null|bool $happens_this_week Whether the event happens on the week of the date
	 *                                                              specified in the `$filter` argument or not, `null`
	 *                                                              if no date is specified in the filter.
	 *                              @type null|int $this_week_duration The days duration of the event on the week
	 *                                                                 specified in the `$filter` argument, `null`
	 *                                                                 if no date is specified in the filter.
	 *                              @type bool $featured Whether the event is a featured one or not.
	 *                              @type string $cost The event formatted cost string, as returned by the `tribe_get_cost`
	 *                                                 `tribe_get_cost` function.
	 *                              @type Lazy_Collection $organizers A collection of Organizers, lazily fetched and
	 *                                                                eventually resolved to an array.
	 *                              @type Lazy_Collection $venues A collection of Venues, lazily fetched and
	 *                                                            eventually resolved to an array.
	 *                              @type Post_Thumbnail $thumbnail The post thumbnail information.
	 *                              @type Lazy_String $schedule_details The event schedule details, as produced by the
	 *                                                                  `tribe_events_event_schedule_details` function.
	 *                              @type Lazy_String $plain_schedule_details The event schedule details, without HTML
	 *                                                                        tags.
	 *                          }
	 */
	function tribe_get_event( $event = null, $output = OBJECT, $filter = 'raw' ) {
		/**
		 * Filters the event result before any logic applies.
		 *
		 * Returning a non `null` value here will short-circuit the function and return the value.
		 * Note: this value will not be cached and the caching of this value is a duty left to the filtering function.
		 *
		 * @since 4.9.7
		 *
		 * @param mixed       $return      The event object to return.
		 * @param mixed       $event       The event object to fetch.
		 * @param string|null $output      The required return type. One of OBJECT, ARRAY_A, or ARRAY_N, which
		 *                                 correspond to a `WP_Post` object, an associative array, or a numeric array,
		 *                                 respectively. Defaults to `OBJECT`.
		 * @param string      $filter      Type of filter to apply. Accepts 'raw', a valid date string or
		 *                                 object to localize the event in a specific time-frame.
		 */
		$return = apply_filters( 'tribe_get_event_before', null, $event, $output, $filter );

		if ( null !== $return ) {
			return $return;
		}

		$post = Event::from_post( $event )->to_post( $output, $filter );

		/**
		 * Filters the event post object before caching it and returning it.
		 *
		 * Note: this value will be cached; as such this filter might not run on each request.
		 * If you need to filter the output value on each call of this function then use the `tribe_get_event_before`
		 * filter.
		 *
		 * @since 4.9.7
		 *
		 * @param WP_Post $post   The event post object, decorated with a set of custom properties.
		 * @param string  $output The output format to use.
		 * @param string  $filter The filter, or context of the fetch.
		 */
		$post = apply_filters( 'tribe_get_event', $post, $output, $filter );

		if ( OBJECT !== $output ) {
			$post = ARRAY_A === $output ? (array) $post : array_values( (array) $post );
		}

		return $post;
	}
}

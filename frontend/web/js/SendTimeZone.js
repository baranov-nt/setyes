/**
 * Created by phpNT on 12.12.2015.
 */
var timezone = '';
var timezoneAbbr = '';
try {
    var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    var timezoneAbbr = /\((.*)\)/.exec(new Date().toString())[1];
    console.log(timezone);
}
catch(err) {
    console.log(err);
}

$.get("/site/timezone.html", {
    timezone: timezone,
    timezoneAbbr: timezoneAbbr,
    timezoneOffset: -new Date().getTimezoneOffset() / 60
});

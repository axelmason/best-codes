import moment from "moment/moment";
import 'moment/locale/ru'  // without this line it didn't work

export function parseTimestamp(timestamp) {
    return moment(timestamp).isValid() ? moment(timestamp).locale('ru').format("L LT") : '-'
}

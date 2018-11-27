import * as $ from "jquery";
import AutocompleteHelper from "../helpers/autocomplete_helper";

export default function receiptsShow() {

    new AutocompleteHelper($('#address-autocomplete')[0]);
}
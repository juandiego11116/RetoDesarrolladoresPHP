import InputTotal from "./components/InputTotal";

require('./bootstrap');
import {createApp} from "vue";
import LabelTotal from "./components/LabelTotal";
createApp({
    components: {
        'label-total': LabelTotal,
        'input-total': InputTotal
    }
}).mount('#app');

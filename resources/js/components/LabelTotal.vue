<template>
    <span>{{total}}</span>

</template>
<script>
import {computed} from 'vue'
import {amount} from '../use/Total'
export default {
    props:['price'],
    setup(props){
        const total = computed(() => {
            return amount.value * props.price
        })
        return {total}
    }
}
</script>
<style></style>

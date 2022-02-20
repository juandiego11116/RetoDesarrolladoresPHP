<template>

    <input type="number" @change="changeAmount" name="amount" :value="amount" >

</template>
<script>
import {amount} from '../use/Total'
export default {
    props:['pamount'],
 setup(props){
        console.log(props.pamount)
        amount.value = props.pamount
     const changeAmount = (e) => { amount.value = e.target.value}
     return {amount, changeAmount}

 }
}
</script>
<style></style>

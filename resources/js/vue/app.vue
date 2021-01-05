<template>
    <div id="app">
        <div>tutaj dodaj nowy</div>
        <table>
            <tr>
                <th>Numer</th>
                <th>Nazwa</th>
                <th>Cena</th>
                <th>Ilość</th>
                <th>Usuń</th>
            </tr>
            <grocery-component v-for="grocery in groceries" v-bind="grocery" :key="grocery.id" @delete="del">
            </grocery-component>
        </table>
    </div>
</template>

<script>

function Grocery({id, name, price, amount}){
    this.id=id;
    this.name=name;
    this.price=price;
    this.amount=amount;
}
import GroceryComponent from './components/GroceryComponent.vue';
export default {
 data(){
     return {
         groceries: []
     }
 },
 methods:{
     async read(){
         const {data}=await window.axios.get('/api/list').then();
         //const { data } = window.axios.get('/api/list');
         console.log(data);
         //console.log(1);
         data.forEach(grocery=>this.groceries.push(new Grocery(grocery)));
     },
     async create(){

     },
     async update(id, name, price, amount){

     },
     async del(id){

     }
 },
 components: {
     GroceryComponent
 },
 created(){
     
       this.read();
 }
}
</script>
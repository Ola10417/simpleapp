<template>
    <div id="app">
        <form @submit.prevent="create()" ref="myForm" >
            <input type="text" v-model="form.name" name="name" placeholder="Nazwa produktu">
            <input type="number" v-model="form.price" name="price" placeholder="Cena" step="0.1" min="0.1">zł
            <input type="number" v-model="form.amount" name="amount" placeholder="Ilość" min="1">
            <button type="submit">Dodaj</button>
        </form>
        <table>
            <tr>
                <th>Numer</th>
                <th>Nazwa</th>
                <th>Cena</th>
                <th>Ilość</th>
                <th>Usuń</th>
                <th>Edytuj</th>
            </tr>
            <grocery-component v-for="grocery in groceries" v-bind="grocery" :key="grocery.id" @delete="del" @update="update">
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
         groceries: [],
         form: new Form({
                id:'',
                name: '',
                price: 0,
                amount: 0
              })
     }
 },
 methods:{
     async read(){
         const {data}=await window.axios.get('/api/list');
         console.log(data[data.length-1].id);
         data.forEach(grocery=>this.groceries.push(new Grocery(grocery)));
         
     },
     async create(){
         this.form.post('/api/list').then(()=>{
             this.groceries=[];
                this.read();
                
                //this.groceries.push(new Grocery(this.form));
                })
                .catch(()=>{

                })
    },
     async update(id){
         
     },
     async del(id){
        await window.axios.delete(`/api/list/${id}`);
         let index=this.groceries.findIndex(grocery=>grocery.id==id);
         this.groceries.splice(index,1);
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
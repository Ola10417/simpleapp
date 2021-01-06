<template>
    <div id="app">
        <form @submit.prevent="edit? editdata() : create()" ref="myForm" >
            <input  v-model="form.id" name="id" hidden >
            <input type="text" v-model="form.name" name="name" placeholder="Nazwa produktu" id="namefield">
            <input type="number" v-model="form.price" name="price" placeholder="Cena" step="0.1" min="0.1" id="pricefield" >zł
            <input type="number" v-model="form.amount" name="amount" placeholder="Ilość" min="1" id="amountfield" >
            <button v-show="!edit" type="submit">Dodaj</button>
            <button v-show="edit" type="submit">Edytuj</button>
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
         edit: false,
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
                this.form.name="";
                this.form.price="";
                this.form.amount="";
                
                //this.groceries.push(new Grocery(this.form));
                })
                .catch(()=>{

                })
    },
     async update(id){
         const {data}=await window.axios.get(`/api/list/${id}`);
         this.form.id=data[0].id;
         this.form.name=data[0].name;
         this.form.price=data[0].price;
         this.form.amount=data[0].amount;
         console.log(data);
         this.edit=true;
     },
     async editdata(){
        this.form.put('/api/list/'+this.form.id).then(()=>{
                //Vue.set(this.groceries, this.groceries.findIndex(grocery => grocery.id===this.form.id), {name:this.form.name, price:this.form.price, amount:this.form.amount })
                
                let g=this.groceries.find(grocery => grocery.id===this.form.id);
                g.name=this.form.name;
                g.price=this.form.price;
                g.amount=this.form.amount;
                this.form.id="";
                this.form.name="";
                this.form.price="";
                this.form.amount="";
                this.edit=false;
                
                })
                .catch(()=>{

                })
    
        //this.cruds.find(crud => crud.id === id).color = color;
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
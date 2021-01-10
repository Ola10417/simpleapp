<template>
    <div id="app">
        <h1 class="pt-4">Lista Zakupów</h1>
        <div class=" container ">
            <form @submit.prevent="edit? editdata() : create()" ref="myForm" class="row py-4 mx-auto ">
                <div class="input-group">
                <input  v-model="form.id" name="id" hidden >
                <input type="text" v-model="form.name" name="name" placeholder="Nazwa produktu" id="namefield" class="form-control col-sm col-lg-4 me-1  me-lg-2">
                <input type="number" v-model="form.price" name="price" placeholder="Cena" step="0.1" min="0.1" id="pricefield" class="form-control col-sm me-1 col-lg-2 me-lg-2">
                <input type="number" v-model="form.amount" name="amount" placeholder="Ilość" min="1" id="amountfield" class="form-control col-sm col-lg-2 me-1  me-lg-2">
                <button v-show="!edit" type="submit" class="btn btn-success rounded col-sm col-lg-2  ">Dodaj</button>
                <button v-show="edit" type="submit" class="btn btn-warning rounded col-sm col-lg-2 ">Edytuj</button>
                </div>
            </form>
        </div>
        
        <h4 class="text-end mt-2"> Do zaplaty: <b>{{totalcost}}  zł</b></h4>
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                
                <th scope="col">Nazwa</th>
                <th scope="col">Cena</th>
                <th scope="col">Ilość</th>
                <th scope="col">Edytuj</th>
                <th scope="col">Usuń</th>
            </tr>
            </thead>
            <tbody>
            <grocery-component v-for="grocery in groceries" v-bind="grocery" :key="grocery.id" @delete="del" @update="update">
            </grocery-component>
            </tbody>
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
                price: '',
                amount: ''
              }),
         totalcost:0
     }
 },
 methods:{
      async countTotalCost(){
         this.totalcost=0;
         this.groceries.forEach(val => {
            this.totalcost += Number(val.price)*Number(val.amount);
        });

     },
     async read(){
         const {data}=await window.axios.get('/api/list');
         data.forEach(grocery=>this.groceries.push(new Grocery(grocery)));
         this.countTotalCost();
         
     },
     async create(){
         this.form.post('/api/list').then(()=>{
                this.groceries=[];
                this.read();
                this.form.name="";
                this.form.price="";
                this.form.amount="";
                Swal.fire(
                'Sukces!',
                'Produkt został dodany do listy zakupów!',
                'success'
                )
                //this.groceries.push(new Grocery(this.form));
                })
                .catch(()=>{
                    Swal.fire({
                    icon: 'error',
                    title: 'Ups...',
                    text: 'Coś poszło nie tak!',
                    })
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
                this.countTotalCost();
                Swal.fire(
                'Sukces!',
                'Produkt został zaktualizowany!',
                'success'
                )
                })
                .catch(()=>{
                    Swal.fire({
                    icon: 'error',
                    title: 'Ups...',
                    text: 'Coś poszło nie tak!',
                    })
                })
    
     },
     async del(id){
         Swal.fire({
            title: 'Czy na pewno chce usunąć produkt z listy?',
            showDenyButton: true,
            
            confirmButtonText: `Usuń`,
            denyButtonText: `Anuluj`,
            }).then((result) => {
            if (result.isConfirmed) {
                window.axios.delete(`/api/list/${id}`);
                let index=this.groceries.findIndex(grocery=>grocery.id==id);
                this.groceries.splice(index,1);
                this.countTotalCost();
                Swal.fire('Produkt został usunięty!', '', 'success')
            } 
        })
        
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
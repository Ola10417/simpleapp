<template>
    
        <tr scope="row">
            <td>{{ name | uppCase }}</td>
            <td>{{ price }}</td>
            <td>{{ amount }}</td>
            <td><button @click="update" class="btn btn-warning">Edytuj</button></td>
            <td><button @click="del" class="btn btn-danger">Usuń</button></td>
        </tr>
    
</template>
<script>
export default {
    methods: {
        del(){
            this.$emit('delete', this.id);
        },
        update(){
            
            this.$emit('update', this.id);
        }
    },
    props:['id', 'name', 'price', 'amount'],
    filters: {
        uppCase(string){
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    }
}
</script>
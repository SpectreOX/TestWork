
<template>
    <div class="container">
      <!-- Button trigger modal -->
      <div class="mx-4">
        <button type="button" class="btn btn-primary btn-sm my-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Category</button>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div v-for="(v, k) in errors" :key="k" >
				<div v-for="error in v" :key="error" class="alert alert-danger" role="alert">
				{{error}}
	
						</div>
						</div>
        <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Category</label>
  <input type="text" required class="form-control" v-model="category.name" id="exampleFormControlInput1" placeholder="Name">
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button"  @click="addCategory()" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Category</th>
            <th>Associated Books</th>
            <th></th>
            </tr>
        </thead>
            <tbody>
              <tr v-for="category in categories.data" :key="category.id">
              <td>{{category.name}}</td>
              <td><small v-for="book in category.books" :key="book.id" >{{book.title}} / </small></td>
              <td> <button type="button" data-bs-toggle="modal" @click="getCategory(category.id)" data-bs-target="#updateCategory" class="btn btn-sm btn-warning">Edit</button>
                    <button type="button" class="btn btn-danger btn-sm"  @click="deleteCategory(category.id)">Delete</button>
              </td>
              </tr>
           </tbody>
       </table>
       
<!-- Modal -->
<div class="modal fade" id="updateCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateCategoryLabel"> Update Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" v-model="category.name" required placeholder="Name">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" @click="updateCategory(category.id)">Update</button>
      </div>
    </div>
  </div>
</div>
  </div>

</template>

<script>
import axios from "axios";

export default {
  beforeRouteEnter(to, from, next) {
        if (!JSON.parse(localStorage.getItem('logged'))) {
            return next('/login');
        }
        next();
    },
    data() {
        return {
            categories: {},
            category: {name: ''},
            errors: '',
        }
    },
    mounted() {
      console.log(JSON.parse(localStorage.getItem('logged')));
        this.getCategories();
    },
    methods: {
        getCategories(){
            axios.get('/api/categories')
            .then(response => {
                this.categories = response.data;
                
            }).catch(err => {
						this.errors = err.response.data.errors;
						console.log(this.errors);
					});
        },
           getCategory(id)
            {
                 axios.get('/api/categories/' + id)
                .then(res => {
                  
                    this.category = res.data.data;
                }).catch(error => console.log(error));
            },
        addCategory() {
          this.errors = '';
            const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
               
          let formData = new FormData();
          formData.append('name', this.category.name);
            
                axios.post('/api/categories',  formData, config).then(res => {
                  if(res.data.status == 201) {
                    this.$swal('Done','Category has been successfully added', 'success');
                    this.getCategories();
                  }
                 

                }).catch(err => {
						this.errors = err.response.data.errors;
						setTimeout(() => this.errors = '', 3000);
					});
           
        },
        updateCategory(id) {
           const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
          let formData = new FormData();
        formData.set('name', this.category.name);
          axios.put('/api/categories/' + id, this.category, formData, config).then(res => {
            if(res.data.status == 201) {
              			this.$swal('Done','Category has been successfully updated','success');
                    this.getCategories();
                    this.category = {name: ''};
                    }
                
            
          }).catch(err => {
						this.errors = err.response.data.errors;
						setTimeout(() => this.errors = '', 3000);
					});
        },

        deleteCategory(id) {        
          axios.delete('/api/categories/' + id, this.category).then(res => {
           console.log(id);
               if(res.data.status == 201) {
                this.$swal('Done',
                'Category has been Successfully removed',
                'success');
                this.getCategories();
                this.category = {};
                }
                else {
                   this.$swal('OOPS!!','This category is associated with some books','error');
                }           
          }).catch(err => console.log(err)); 
        }
    }

}
</script>


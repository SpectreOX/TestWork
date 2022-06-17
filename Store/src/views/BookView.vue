
<template>
    <div class="container">
        <button type="button" class="my-3 btn btn-primary btn-sm" :class="this.categories.count == 0 ? disabled : ''" data-bs-toggle="modal" data-bs-target="#exampleModal">Add book</button>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Book</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div v-for="(v, k) in errors" :key="k" >
				<div v-for="error in v" :key="error" class="alert alert-danger" role="alert">
				{{error}}
	
						</div>
						</div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Title</label>
            <input type="text" required class="form-control" v-model="book.title" placeholder="The art of seduction, Crime and punishment ...">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Category</label>
            <div>
        <select required v-model="book.category_id" class="form-select">
      <option  v-for="category in categories.data" :key="category.id" :value="category.id" >{{category.name}}</option>
      </select>
        </div>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Author name</label>
            <input type="text" required class="form-control" v-model="book.author_name" placeholder="Robert greene , Victor Hugo ...">
            </div>
              <div class="mb-3">
            <label for="publish_date" class="form-label">Publish Date</label>
            <Datepicker v-model="this.book.publish_date" yearPicker autoApply :maxDate="new Date()" />
            </div>
      
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">ISBN</label>
            <input type="text" required class="form-control" v-model="book.isbn" placeholder="ISBN">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Description</label>
            <textarea type="text" required class="form-control" v-model="book.description" cols="10" rows="10"> </textarea>
        </div>
       </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button"  @click="addBook()" class="btn btn-primary" data-bs-dismiss="modal">Add Book</button>
      </div>
    </div>
  </div>
</div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Book</th>
            <th>Author Name</th>
            <th>Category</th>
            <th>ISBN</th>
            <th></th>
            </tr>
        </thead>
            <tbody>
              <tr v-for="book in books.data" :key="book.id">
              <td>{{book.title}}</td>
              <td>{{book.author_name}}</td>
              <td>{{book.category}}</td>
              <td>{{book.isbn}}</td>
              <td> <button type="button" data-bs-toggle="modal" @click="getBook(book.id)" data-bs-target="#updateBook" class="btn btn-sm btn-warning">Edit</button>
                    <button type="button" class="btn btn-danger btn-sm"  @click="deleteBook(book.id)">Delete</button>
              </td>
              </tr>
           </tbody>
       </table>
  </div>
  <!-- Modal -->
<div class="modal fade" id="updateBook" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateCategoryLabel">Update Book</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div v-for="(v, k) in errors" :key="k" >
				<div v-for="error in v" :key="error" class="alert alert-danger" role="alert">
				{{error}}
				</div>
				 </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Title</label>
            <input type="text" required class="form-control" v-model="book.title" placeholder="The art of seduction, Crime and punishment ...">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Category</label>
            <div>
        <select required v-model="book.category_id" class="form-select">
      <option  v-for="category in categories.data" :key="category.id" :value="category.id" >{{category.name}}</option>
      </select>
        </div>
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Author name</label>
            <input type="text" required class="form-control" v-model="book.author_name" placeholder="Robert greene , Victor Hugo ...">
            </div>
              <div class="mb-3">
            <label for="publish_date" class="form-label">Publish Date</label>
            <Datepicker v-model="this.book.publish_date" yearPicker autoApply :maxDate="new Date()" />
            </div>
      
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">ISBN</label>
            <input type="text" required class="form-control" v-model="book.isbn" placeholder="ISBN">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Description</label>
            <textarea type="text" required class="form-control" v-model="book.description" cols="10" rows="10"> </textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" @click="updateBook(book.id)">Update</button>
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
            books: {},
            book: {title: '', category_id: '', author_name: '', isbn: '', description: '', publish_date: ''},
            errors : '',
            
        }
    },
    mounted() {
        this.getBooks();
        this.getCategories();
    },
    methods: {
        getCategories(){
            axios.get('/api/categories')
            .then(response => {
                this.categories = response.data;
                console.log(this.categories);
            }).catch(err => console.log(err));
        },
        getBooks(){
            axios.get('/api/books')
            .then(response => {
                this.books = response.data;
            }).catch(err => console.log(err));
        },
           getBook(id)
            {
                axios.get('/api/books/' + id)
                .then(res => {          
                    this.book = res.data.data;
                }).catch(error => console.log(error));
            },
        addBook() {
            const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
               console.log(this.book.publish_date);
        let formData = new FormData();
        formData.append('title', this.book.title);
        formData.append('author_name', this.book.author_name);
        formData.append('description', this.book.description);
        formData.append('category_id', this.book.category_id)
        formData.append('isbn', this.book.isbn);
        formData.append('publish_date', this.book.publish_date);
        axios.post('/api/books',  formData, config).then(res => {
          if(res.data.status == 201) {
            this.$swal('Done','Book has been successfully added', 'success');
            this.getBooks();
            }
            }).catch(err => {
						this.errors = err.response.data.errors;
						setTimeout(() => this.errors = '', 10000);
					});
           
        },
        updateBook(id) {
           const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
          let formData = new FormData();
          formData.append('title', this.book.title);
          formData.append('author_name', this.book.author_name);
          formData.append('description', this.book.description);
          formData.append('isbn', this.book.isbn);
          formData.append('publish_date', this.book.publish_date);
        
          axios.put('/api/books/' + id, this.book, formData, config).then(res => {
            if(res.data.status == 201) {    
              this.$swal('Done','Book has been successfully updated', 'success');         
                    this.getbooks();
                    this.book = {};
                    }
                   
            
          }).catch(err => {
						this.errors = err.response.data.errors;
						setTimeout(() => this.errors = '', 10000);
					});
        },

        deleteBook(id) {        
          axios.delete('/api/books/' + id, this.book).then(res => {
           
               if(res.data.status == 201) {
                this.$swal('done','Book has been successfully removed', 'success');
                    this.getBooks();
                    this.book = {};
                    }
          }).catch(err => console.log(err)); 
        }
    }

}
</script>


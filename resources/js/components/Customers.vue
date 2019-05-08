<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Customers</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal()">Add New</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-responsive-md">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>BR NO</th>
                                <th>Action</th>
                            </tr>
                            <tr v-for="customer in customers.data" :key="customer.id">
                                <td>{{customer.id}}</td>
                                <td>{{customer.customer_name}}</td>
                                <td>{{customer.email}}</td>
                                <td>{{customer.br_no}}</td>
                                <td>
                                    <button @click="editModal(customer)">
                                        <i class="fa fa-edit text-primary"></i>
                                    </button>
                                    /
                                    <button @click="deleteCustomer(customer.id)">
                                        <i class="fa fa-trash text-danger"></i>
                                    </button>
                                </td>
                            </tr>


                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update Customer's Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateCustomer() : createCustomer()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.customer_name" type="text" name="customer_name"
                                       placeholder="Name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('customer_name') }">
                                <has-error :form="form" field="customer_name"></has-error>
                            </div>

                            <div class="form-group">
                                <input v-model="form.email" type="email" name="email"
                                       placeholder="Email Address"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.br_no" type="text" name="br_no"
                                       placeholder="BR No"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('br_no') }">
                                <has-error :form="form" field="br_no"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.website" type="text" name="website"
                                       placeholder="website"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('website') }">
                                <has-error :form="form" field="website"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.address" type="text" name="address"
                                       placeholder="address"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                                <has-error :form="form" field="address"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.contact_no" type="text" name="contact_no"
                                       placeholder="contact no"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('contact_no') }">
                                <has-error :form="form" field="contact_no"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                            <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>


    </div>
</template>

<script>

    import axios from 'axios';

    export default {
        data() {
            return {
                customers: {},
                editmode: false,
                form: new Form({
                    id: '',
                    customer_name: '',
                    br_no: '',
                    website: '',
                    address: '',
                    contact_no: '',
                    email: ''
                })
            }
        },
        methods: {
            newModal() {
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show')
            },
            editModal(customer) {
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show')
                this.form.fill(customer)
            },
            loadCustomers() {
                axios.get("api/customer").then(({data}) => (this.customers = data));

            },
            createCustomer() {
                this.$Progress.start();
                this.form.post('api/customer')
                    .then(() => {
                        Fire.$emit('AfterCreate')
                        $('#addNew').modal('hide')
                        toast.fire({
                            type: 'success',
                            title: 'Customer Created successfully'
                        })
                        this.$Progress.finish();
                    })
                    .catch(() => {

                    })
            },
            updateCustomer() {
                this.$Progress.start();
                this.form.put('api/customer/' + this.form.id)
                    .then(() => {
                        $('#addNew').modal('hide')
                        Fire.$emit('AfterCreate')
                        Swal.fire(
                            'Updated!',
                            'Info has been updated.',
                            'success'
                        )
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail()
                    })
            },
            deleteCustomer(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    this.form.delete('api/customer/' + id).then(() => {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                        Fire.$emit('AfterCreate')
                    }).catch(() => {
                        swal("Failed !", "There was something wrong. ", "warning");
                    });

                })
            }
        },
        created() {
            this.loadCustomers();
            Fire.$on('AfterCreate', () => {
                this.loadCustomers();
            });
        }
    }
</script>

<style scoped>

</style>

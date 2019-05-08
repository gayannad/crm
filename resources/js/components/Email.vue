<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Email</h3>

                    </div>
                    <div class="card-body">
                        <form @submit.prevent="editmode ? updateUser() : createUser()">
                            <div class="modal-body">
                                <div class="form-group">
                                    <input v-model="form.customer" type="text" name="customer"
                                           placeholder="customer id"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('customer') }">
                                    <has-error :form="form" field="customer"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.to" type="text" name="to"
                                           placeholder="TO"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('to') }">
                                    <has-error :form="form" field="to"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.cc" type="text" name="cc"
                                           placeholder="CC"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('cc') }">
                                    <has-error :form="form" field="cc"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.bcc" type="text" name="bcc"
                                           placeholder="BCC"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('bcc') }">
                                    <has-error :form="form" field="bcc"></has-error>
                                </div>
                                <div class="form-group">
                                    <input v-model="form.subject" type="text" name="subject"
                                           placeholder="subject"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('subject') }">
                                    <has-error :form="form" field="subject"></has-error>
                                </div>
                                <div class="form-group">
                                    <textarea name="body" id="body" cols="30" rows="5" v-model="form.body"
                                              placeholder="body" class="form-control"
                                              :class="{ 'is-invalid': form.errors.has('body') }"></textarea>
                                    <has-error :form="form" field="body"></has-error>
                                </div>
                            </div>
                            <div class="float-right">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>

                        </form>
                    </div>
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
                users: {},
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    level: ''
                })
            }
        },
        methods: {
            newModal() {
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show')
            },
            editModal(user) {
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show')
                this.form.fill(user)
            },
            loadUsers() {
                axios.get("api/user").then(({data}) => (this.users = data));

            },
            createUser() {
                this.$Progress.start();
                this.form.post('api/user')
                    .then(() => {
                        Fire.$emit('AfterCreate')
                        $('#addNew').modal('hide')
                        toast.fire({
                            type: 'success',
                            title: 'User Created successfully'
                        })
                        this.$Progress.finish();
                    })
                    .catch(() => {

                    })
            },
            updateUser() {
                this.$Progress.start();
                this.form.put('api/user/' + this.form.id)
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
            deleteUser(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    this.form.delete('api/user/' + id).then(() => {
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
            this.loadUsers();
            Fire.$on('AfterCreate', () => {
                this.loadUsers();
            });
        }
    }
</script>

<style scoped>

</style>

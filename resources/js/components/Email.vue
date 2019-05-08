<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users</h3>

                    </div>
                    <div class="card-body">
                        <form @submit.prevent="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <input v-model="form.name" type="text" name="name"
                                           placeholder="Name"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>

                                <div class="form-group">
                                    <input v-model="form.email" type="email" name="email"
                                           placeholder="Email Address"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                </div>

                                <div class="form-group">
                                    <select name="level" v-model="form.level" id="level" class="form-control"
                                            :class="{ 'is-invalid': form.errors.has('level') }">
                                        <option value="">Select User Level</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Sales Staff</option>
                                    </select>
                                    <has-error :form="form" field="level"></has-error>
                                </div>

                                <div class="form-group">
                                    <input v-model="form.password" type="password" name="password" id="password"
                                           class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" placeholder="Password">
                                    <has-error :form="form" field="password"></has-error>
                                </div>

                            </div>
                            <div >
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>


    </div>
</template>


<style scoped>

</style>

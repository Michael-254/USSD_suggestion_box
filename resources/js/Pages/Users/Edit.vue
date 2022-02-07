<template>
 <Head title="Edit-User" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit/User/{{ User.id }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex flex-col">
                                <div class="w-full">
                                   <div class="mt-10 sm:mt-0">
                                        <div class="md:grid md:grid-cols-3 md:gap-6">
                                            <div class="md:col-span-1">
                                            <div class="px-4 sm:px-0">
                                                <h3 class="text-lg font-medium leading-6 text-gray-900">User Information</h3>
                                                <p class="mt-1 text-sm text-gray-600">
                                                   Edit {{ User.name }} Information
                                                </p>
                                            </div>
                                            </div>
                                            <div class="mt-5 md:mt-0 md:col-span-2">
                                            <form @submit.prevent="update(`${User.id}`)">
                                                <div class="shadow overflow-hidden sm:rounded-md">
                                                <div class="px-4 py-5 bg-white sm:p-6">
                                                    <div class="grid grid-cols-6 gap-6">
                                                    <div class="col-span-6 sm:col-span-3">
                                                        <label for="first_name" class="block text-sm font-medium text-gray-700">Job Title</label>
                                                        <input type="text" v-model="form.name" class="mt-1 btn-green">
                                                        <div class="text-xs text-red-600 mt-1" v-if="form.errors.name">{{ form.errors.name }}</div>
                                                    </div>

                                                    <div class="col-span-6 sm:col-span-3">
                                                        <label for="last_name" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                                        <input type="text" v-model="form.phone_number" class="mt-1 btn-green">
                                                        <div class="text-xs text-red-600 mt-1" v-if="form.errors.phone_number">{{ form.errors.phone_number }}</div>
                                                    </div>

                                                    <div class="col-span-6 sm:col-span-3 lg:col-span-3">
                                                        <label for="state" class="block text-sm font-medium text-gray-700">Site</label>
                                                        <select type="text" v-model="form.site" class="mt-1 btn-green">
                                                            <option value="Nyongoro">Nyongoro</option>                                           
                                                            <option value="Kiambere">Kiambere</option>                                           
                                                            <option value="Dokolo">Dokolo</option>
                                                            <option value="7 Forks">7 Forks</option>
                                                            <option value="Head Office">Head Office</option>
                                                            <option value="Kampala">Kampala</option>
                                                            <option value="Tanzania">Tanzania</option>
                                                        </select>
                                                        <div class="text-xs text-red-600 mt-1" v-if="form.errors.site">{{ form.errors.site }}</div>
                                                    </div>

                                                    <div class="col-span-6 sm:col-span-3 lg:col-span-3">
                                                        <label for="postal_code" class="block text-sm font-medium text-gray-700">Department</label>
                                                        <select type="text" v-model="form.dept" autocomplete="postal-code" class="mt-1 btn-green">
                                                            <option value="IT">IT</option>                                           
                                                            <option value="Forestry">Forestry</option>                                           
                                                            <option value="Operations">Operations</option>
                                                            <option value="Human Resources">Human Resources</option>
                                                            <option value="Operations">Operations</option>
                                                            <option value="Communications">Communications</option>
                                                            <option value="Finance">Finance</option>
                                                            <option value="ME">Monitoring n Evaluation</option>
                                                        </select>
                                                        <div class="text-xs text-red-600 mt-1" v-if="form.errors.dept">{{ form.errors.dept }}</div>
                                                    </div>

                                                    <div class="col-span-6 sm:col-span-3 lg:col-span-3">
                                                        <label for="state" class="block text-sm font-medium text-gray-700">Email</label>
                                                        <input type="email" v-model="form.email" class="mt-1 btn-green">
                                                        <div class="text-xs text-red-600 mt-1" v-if="form.errors.email">{{ form.errors.email }}</div>
                                                    </div>

                                                    <div class="col-span-6 sm:col-span-3 lg:col-span-3">
                                                        <label for="postal_code" class="block text-sm font-medium text-gray-700">Supervisor Email</label>
                                                        <input type="text" v-model="form.supervisor_email" class="mt-1 btn-green">
                                                        <div class="text-xs text-red-600 mt-1" v-if="form.errors.supervisor_email">{{ form.errors.supervisor_email }}</div>
                                                    </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                                    <Button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                                        Save
                                                    </Button>
                                                </div>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                   </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>

</template>

<script>

import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Button from '@/Components/Button.vue'
import { Head,Link } from '@inertiajs/inertia-vue3';
export default {
   components:{
     BreezeAuthenticatedLayout,
     Head,
     Button,
     Link,
   },
   data() {
    return {
      form: this.$inertia.form({
        name: this.$props.User.name,
        phone_number: this.$props.User.phone_number,
        email: this.$props.User.email,
        supervisor_email: this.$props.User.supervisor_email,
        site: this.$props.User.site,
        dept: this.$props.User.dept,
      }),
    }
  },
  methods: {
    update(id) {
        this.form.patch(`/update/${id}`)
     }
  },
   props: {
      User: Object,
    },
}
</script>

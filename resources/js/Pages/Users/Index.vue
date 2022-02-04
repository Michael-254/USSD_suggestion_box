<template>
 <Head title="Users" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex flex-col">
                                <div class="w-full">
                                    <div v-if="$page.props.flash != false">
                                         <div id="alert-border-1" class="flex p-4 mb-4 bg-blue-100 border-t-4 border-blue-500 dark:bg-blue-200" role="alert">                                         
                                            <div class="ml-3 text-sm font-medium text-blue-700">
                                               {{ $page.props.flash }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="border-b border-gray-200 shadow">
                                        <div class="flex justify-between space-x-2 mb-6 px-2 pt-2">
                                            <select v-model="site" @change="search()" class="w-full border rounded-lg text-xs border-green-400 focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-500 ease-in-out focus:ring-opacity-100 focus:border-green-400 focus:ring-green-400">
                                                <option value="">Site</option>                                           
                                                <option value="Nyongoro">Nyongoro</option>                                           
                                                <option value="Kiambere">Kiambere</option>                                           
                                                <option value="Dokolo">Dokolo</option>
                                                <option value="7 Forks">7 Forks</option>
                                                <option value="Head Office">Head Office</option>
                                                <option value="Kampala">Kampala</option>
                                                <option value="Tanzania">Tanzania</option>
                                            </select>   
                                            <select v-model="dept" @change="search()" class="w-full border rounded-lg text-xs border-green-400 focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-500 ease-in-out focus:ring-opacity-100 focus:border-green-400 focus:ring-green-400">
                                                <option value="">Department</option>                                           
                                                <option value="IT">IT</option>                                           
                                                <option value="Forestry">Forestry</option>                                           
                                                <option value="Operations">Operations</option>
                                                <option value="Human Resources">Human Resources</option>
                                                <option value="Operations">Operations</option>
                                                <option value="Communications">Communications</option>
                                                <option value="ME">Monitoring n Evaluation</option>
                                            </select>   
                                            <input v-model="term" @keyup="search()" class="w-full border rounded-lg text-xs border-green-400 focus:outline-none focus:ring-2 focus:ring-offset-2 transition duration-500 ease-in-out focus:ring-opacity-100 focus:border-green-400 focus:ring-green-400" type="text" placeholder="search...">
                                        </div>
                                         <table class="w-full">
                                            <thead>
                                                <tr>
                                                    <th
                                                        class="px-6 py-3 text-xs text-green-600 font-bold leading-4 tracking-wider text-left uppercase border-b border-gray-200 bg-gray-50">
                                                        ID</th>
                                                    <th
                                                        class="px-6 py-3 text-xs text-green-600 font-bold leading-4 tracking-wider text-left uppercase border-b border-gray-200 bg-gray-50">
                                                        Job Title</th>
                                                    <th
                                                        class="px-6 py-3 text-xs text-green-600 font-bold leading-4 tracking-wider text-left uppercase border-b border-gray-200 bg-gray-50">
                                                        Site</th>
                                                    <th
                                                        class="px-6 py-3 text-xs text-green-600 font-bold leading-4 tracking-wider text-left uppercase border-b border-gray-200 bg-gray-50">
                                                        Department</th>
                                                    <th
                                                        class="px-6 py-3 text-xs text-green-600 font-bold leading-4 tracking-wider text-left uppercase border-b border-gray-200 bg-gray-50">
                                                        Phone Number</th>
                                                    <th
                                                        class="px-6 py-3 text-xs text-green-600 font-bold leading-4 tracking-wider text-left uppercase border-b border-gray-200 bg-gray-50">
                                                        Edit</th>
                                                    <th
                                                        class="px-6 py-3 text-xs text-green-600 font-bold leading-4 tracking-wider text-left uppercase border-b border-gray-200 bg-gray-50">
                                                        Delete</th>
                                                </tr>
                                             </thead>

                                             <tbody class="bg-white">
                                                <tr v-for="user in Users.data" :key="user.id">
                                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                        <div class="flex items-center">
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium leading-5 text-gray-900">
                                                                    {{ user.id }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                        <div class="text-sm leading-5 text-gray-500">{{ user.name }}</div>
                                                    </td>

                                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                        <span
                                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-yellow-100 rounded-full">{{ user.site }}</span>
                                                    </td>
                                                    
                                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                        <span
                                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800  rounded-full">{{ user.dept }}</span>
                                                    </td>

                                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                                        <span
                                                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">{{ user.phone_number }}</span>
                                                    </td>

                                                    <td class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                                         <Link :href="route('edit.user', {id: user.id})" class="rounded-lg bg-indigo-500 px-2 py-2 h-8 text-white text-xs hover:bg-indigo-700">
                                                            Edit
                                                        </Link>
                                                    </td>
                                                    <td class="px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                                         <button @click.prevent="destroy(`${user.id}`)" class="rounded-lg bg-red-500 px-2 py-2 h-8 text-white text-xs hover:bg-red-700">
                                                            Delete
                                                         </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-3 flex justify-end">
                                        <pagination class="mt-6" :links="Users.links" />
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
import Pagination from '@/Components/Pagination'
import { Head,Link } from '@inertiajs/inertia-vue3';
export default {
   components:{
     BreezeAuthenticatedLayout,
     Head,
     Button,
     Link,
     Pagination
   },
   data(){
       return {
           term: this.$props.filters.term,
           site: this.$props.filters.site,
           dept: this.$props.filters.dept,
       }
   },
   methods: {
    search() {
      this.$inertia.get('/users',{term: this.term,site: this.site,dept: this.dept},{preserveState: true, replace: true})
    },
    destroy(id) {
        if (confirm('Are you sure you want to delete this User?')) {
           this.$inertia.delete(`/destroy/${id}`);
        }
    },
  },
   props: {
      Users: Object,
      filters: Object,
    },
}
</script>

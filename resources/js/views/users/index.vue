<script>
import Layout from "../../layouts/main.vue";
import PageHeader from "../../components/page-header.vue";
import Pagination from "../../components/common/pagination.vue";
import axios from "axios";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
/**
 * Contacts-list component
 */
export default {
    components: { Layout, PageHeader, Pagination, flatPickr },
    data() {
        return {
            searchQuery: null,
            resultQuery: [],
            result: [],
            defaultDateConfig: {
                dateFormat: "d M, Y",
                defaultDate: "25 Dec, 2021",

            },
            perPage: 1,
            currentPage: 1,
            totalRecords: 1,
            lastPage: 1,
            from: 1,
            to: 1,
            status: 'all',
            processing: false,
            isFetchError: false,
            fetchError: null,
            accessToken: null,
            sanitizedToken: null,
        };
    },
    mounted() {
        if (localStorage.getItem('accessToken') != null) {
            this.accessToken = localStorage.getItem('accessToken')
            this.sanitizedToken = this.accessToken.replace(/^"(.*)"$/, '$1');
        }
    },
    watch: {
        searchQuery(newVal) {
            if (newVal) {
                const search = newVal.toLowerCase();
                this.resultQuery = this.displayedPosts.filter((data) => {
                    return (
                        data.name.toLowerCase().includes(search) ||
                        data.email.toLowerCase().includes(search) ||
                        data.address.toLowerCase().includes(search) ||
                        data.phone.toLowerCase().includes(search)
                    );
                });
            } else {
                this.resultQuery = this.result
            }

        }
    },
    computed: {
        displayedPosts() {
            return this.resultQuery;
        },
    },
    methods: {
        paginate(users) {
            this.totalRecords = users.total;
            this.perPage = users.per_page;
            this.from = users.from;
            this.to = users.to;
            this.lastPage = users.last_page;
            this.currentPage = users.current_page;
        },
        async listData(page = 1) {
            try {
                const response = await axios.get(`/api/admin/users/list?page=${page}`, {
                    headers: {
                        'Authorization': `Bearer ${this.sanitizedToken}`
                    }
                });

                if (response.status === 200) {
                    const data = response.data;

                    if (data.error == false && data.message == 'success') {
                        this.resultQuery = data.result.data;
                        this.result = data.result.data;
                        this.paginate(data.result)
                    } else {
                        if (data.error == true) {
                            this.fetchError = data.message;
                            this.isFetchError = data.error;
                        }
                    }

                }
            } catch (error) {
                if (error.response.status === 403) {
                    this.$router.push('/error/403');
                }
                console.error('Error fetching data:', error); // Log any errors that occur during the request
            }
        },
        async SearchData() {
            return this.listData(this.page, this.status);
        }
    }
};
</script>


<template>
    <Layout>
        <PageHeader title="Users List" pageTitle="Users" />
        <BAlert v-model="isFetchError" variant="danger" class="mt-3" dismissible>{{ fetchError }}
        </BAlert>
        <BRow>
            <BCol lg="12">
                <BCard no-body>
                    <BCardBody class="border-bottom">
                        <div class="d-flex align-items-center">
                            <BCardTitle class="mb-0 flex-grow-1">Client Lists</BCardTitle>

                            <div class="flex-shrink-0">
                                <BLink href="/users/create" class="btn btn-primary me-1">Add New User</BLink>
                                <BLink href="#!" class="btn btn-light me-1"><i class="mdi mdi-refresh"></i></BLink>

                                <BDropdown variant="success" class="job-list-dropdown">
                                    <template #button-content><i class="mdi mdi-dots-vertical"></i>
                                    </template>
                                    <BDropdownItem href="#">Action</BDropdownItem>
                                    <BDropdownItem href="#">Another action</BDropdownItem>
                                    <BDropdownItem href="#">Something else here</BDropdownItem>
                                </BDropdown>
                            </div>
                        </div>
                    </BCardBody>

                    <BCardBody class="border-bottom">
                        <BRow class="g-3">
                            <BCol xxl="4" lg="6">
                                <BFormInput type="text" class="form-control search" placeholder="Search for ..."
                                    v-model="searchQuery" />
                            </BCol>

                            <BCol xxl="2" lg="6">
                                <select :close-on-select="true" :searchable="true" v-model="this.status"
                                    placeholder="Status" :create-option="true" class="form-select" id="idStatus"
                                    aria-label="Default select example">
                                    <option value="" selected>Status</option>
                                    <option value="all">All</option>
                                    <option value="interested">Interested</option>
                                    <option value="not_interested">Not Interested</option>
                                </select>
                            </BCol>

                            <BCol xxl="2" lg="6">
                                <select id="idType" aria-label="Default select example" v-model="value1"
                                    :close-on-select="true" :searchable="true" :create-option="true"
                                    placeholder="Select Type" class="form-select">
                                    <option value="all">Select Type</option>
                                    <option value="Full Time">Full Time</option>
                                    <option value="Part Time">Part Time</option>
                                </select>
                            </BCol>

                            <BCol xxl="2" lg="6">
                                <flat-pickr v-model="date6" :config="defaultDateConfig" class="form-control"
                                    placeholder="Select date"></flat-pickr>
                            </BCol>

                            <BCol xxl="2" lg="6">
                                <BButton variant="soft-secondary" @click="SearchData" class="w-100"> <i
                                        class="mdi mdi-filter-outline align-middle"></i>
                                    Filter
                                </BButton>
                            </BCol>
                        </BRow>
                    </BCardBody>

                    <BCardBody>
                        <div class="table-responsive">
                            <BTableSimple class="align-middle dt-responsive nowrap w-100 table-check" id="job-list">
                                <BThead>
                                    <BTr>
                                        <BTh scope="col">No</BTh>
                                        <BTh scope="col">Name</BTh>
                                        <BTh scope="col">Email</BTh>
                                        <BTh scope="col">Phone</BTh>
                                        <BTh scope="col">Role</BTh>
                                        <BTh scope="col">Address</BTh>
                                        <BTh scope="col">Action</BTh>
                                    </BTr>
                                </BThead>

                                <BTbody>
                                    <BTr v-for="(user, index) in this.resultQuery" :key="user.id">
                                        <BTh scope="row">{{ (currentPage - 1) * perPage + index + 1 }} </BTh>
                                        <BTd>{{ user.name }} </BTd>
                                        <BTd>{{ user.email }} </BTd>
                                        <BTd>{{ user.phone }} </BTd>
                                        <BTd>
                                            <div v-for="(role, roleIndex) in user.roles" :key="roleIndex">
                                                <BLink href="javascript: void(0);"
                                                    class="badge badge-soft-primary font-size-11 m-1"> {{
                                                        role.name }}
                                                    <span v-if="roleIndex !== user.roles.length - 1">, </span>

                                                </BLink>

                                            </div>
                                        </BTd>
                                        <BTd>{{ user.address }} </BTd>
                                        <BTd>
                                            <ul class="list-unstyled hstack gap-1 mb-0">
                                                <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="View">
                                                    <router-link to="/client/details/"
                                                        class=" btn btn-sm btn-soft-primary"><i
                                                            class="mdi mdi-eye-outline"></i></router-link>
                                                </li>
                                                <li data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Edit">
                                                    <Blink href="#" class="btn btn-sm btn-soft-info"><i
                                                            class="mdi mdi-pencil-outline"></i>
                                                    </Blink>
                                                </li>
                                                <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                    aria-label="Delete">
                                                    <Blink href="#jobDelete" data-bs-toggle="modal"
                                                        class="btn btn-sm btn-soft-danger"><i
                                                            class="mdi mdi-delete-outline"></i></Blink>
                                                </li>
                                            </ul>
                                        </BTd>
                                    </BTr>
                                </BTbody>
                            </BTableSimple>
                        </div>

                        <BRow class="justify-content-between align-items-center">
                            <BCol class="col-auto me-auto">
                                <p class="text-muted mb-0">Showing <b>{{ currentPage }}</b> to <b>{{ lastPage }}</b> of
                                    <b>{{ totalRecords }}</b> entries
                                </p>
                            </BCol>
                            <BCol class="col-auto">
                                <BCard no-body class="d-inline-block ms-auto mb-0">
                                    <BCardBody class="p-2">
                                        <nav aria-label="Page navigation example" class="mb-0">

                                            <BPagination v-model="currentPage" v-on="this.listData(currentPage)"
                                                :pills="true" :total-rows="totalRecords" :per-page="perPage">
                                            </BPagination>

                                            <!-- <pagination :pills="true" :ex4-rows="230">
                                            </pagination> -->

                                        </nav>
                                    </BCardBody>
                                </BCard>
                            </BCol>
                        </BRow>

                    </BCardBody>
                </BCard>
            </BCol>
        </BRow>

    </Layout>
</template>

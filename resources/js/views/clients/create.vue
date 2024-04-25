<script>
import Layout from "../../layouts/main.vue";
import PageHeader from "../../components/page-header.vue";
import axios from 'axios';
/**
 * Form Layouts component
 */
export default {
    components: { Layout, PageHeader },
    data() {
        return {
            formData: {
                name: "",
                email: "",
                second_email: "",
                website: "",
                phone: "",
            },
            processing: false,
            formError: null,
            isFormError: false,
        };
    },
    methods: {

        async submit() {
            this.processing = true;

            await axios.post('/api/clients/store', this.formData).then(({ data }) => {
                if (data.success == true && data.message == 'success') {
                    console.log(data);
                    this.processing = false;
                    this.$router.push('/clients');

                } else {
                    if (data.data == 400) {
                        this.formError = data.message;
                        this.isFormError = true;
                    }
                }
            }).catch(({ response: { data } }) => {
                console.log(data)
            }).finally(() => {
                this.processing = false
            })
        }
    }
};
</script>

<template>
    <Layout>
        <PageHeader title="Add Client" pageTitle="Clients" />
        <BRow>
            <BCol lg="6">
                <BCard no-body>
                    <BCardBody>
                        <BCardTitle class="mb-4">Create Client</BCardTitle>
                        <BAlert v-model="isFormError" variant="danger" class="mt-3" dismissible>{{ formError }}
                        </BAlert>
                        <BForm action="javascript:void(0)" method="POST">
                            <BFormGroup class="mb-3" label="Name" label-for="horizontal-firstname-input"
                                label-cols-sm="3">
                                <BFormInput id="horizontal-firstname-input" type="text" v-model="formData.name"
                                    name="name" placeholder="Enter Your Name">
                                </BFormInput>
                            </BFormGroup>

                            <BFormGroup class="mb-4" label="Email" label-for="horizontal-email-input" label-cols-sm="3">
                                <BFormInput id="horizontal-email-input" type="email" name="email"
                                    v-model="formData.email" placeholder="Enter Your Email ID">
                                </BFormInput>
                            </BFormGroup>
                            <BFormGroup class="mb-4" label="Second Email" label-for="horizontal-email-input"
                                label-cols-sm="3">
                                <BFormInput id="horizontal-email-input" type="email" name="second_email"
                                    v-model="formData.second_email" placeholder="Enter Your Second Email ID">
                                </BFormInput>
                            </BFormGroup>

                            <BFormGroup class="mb-4" label="Website" label-for="horizontal-password-input"
                                label-cols-sm="3">
                                <BFormInput id="horizontal-password-input" type="text" name="website"
                                    v-model="formData.website" placeholder="Enter Your Website">
                                </BFormInput>
                            </BFormGroup>

                            <BFormGroup class="mb-4" label="Phone" label-for="horizontal-phone-input" label-cols-sm="3">
                                <BFormInput id="horizontal-phone-input" name="phone" type="text"
                                    v-model="formData.phone" placeholder="Enter Your Phone">
                                </BFormInput>
                            </BFormGroup>

                            <BRow class="justify-content-end">
                                <BCol sm="9">
                                    <div>
                                        <BButton ariant="primary" type="submit" :disabled="processing" @click="submit"
                                            class="btn-block">
                                            {{ processing ? "Please wait" : "Submit" }}
                                        </BButton>
                                    </div>
                                </BCol>
                            </BRow>
                        </BForm>
                    </BCardBody>
                </BCard>
            </BCol>
        </BRow>


    </Layout>
</template>

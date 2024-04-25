<script>
import errorImg from '../../../images/error-img.png';
import Layout from "../../layouts/main.vue";

export default {
    components: { Layout },
    data() {
        return {
            errorImg
        }
    }
}
</script>
<template>
    <Layout>
        <div class="account-pages my-5 pt-5">
            <BContainer>
                <BRow>
                    <BCol lg="12">
                        <div class="text-center mb-5">
                            <h1 class="display-2 fw-medium">
                                4<i class="bx bx-buoy bx-spin text-primary display-3"></i>3
                            </h1>
                            <h4 class="text-uppercase">Sorry, You do not have permission to access this resource</h4>
                            <div class="mt-5 text-center">
                                <router-link to="/">
                                    <BButton variant="primary">Back to Dashboard</BButton>
                                </router-link>
                            </div>
                        </div>
                    </BCol>
                </BRow>
                <BRow class="justify-content-center">
                    <BCol md="8" xl="6">
                        <div>
                            <img :src="errorImg" alt class="img-fluid" />
                        </div>
                    </BCol>
                </BRow>
            </BContainer>
        </div>
    </Layout>
</template>

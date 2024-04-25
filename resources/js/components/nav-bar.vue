<script>

import simplebar from "simplebar-vue";
import us from '../../images/flags/us.jpg';
import fr from '../../images/flags/french.jpg';
import es from '../../images/flags/spain.jpg';
import zh from '../../images/flags/chaina.png';
import ar from '../../images/flags/arabic.png';

import logoDarkLg from '../../images/logo-dark.png';
import logoDarkSm from '../../images/logo.svg';
import logoLightLg from '../../images/logo-light.png';
import logoLightSm from '../../images/logo-light.svg';

import avatar1 from '../../images/users/avatar-1.jpg';
import avatar3 from '../../images/users/avatar-3.jpg';
import avatar4 from '../../images/users/avatar-4.jpg';

import github from '../../images/brands/github.png';
import bitbucket from '../../images/brands/bitbucket.png';
import dribbble from '../../images/brands/dribbble.png';
import dropbox from '../../images/brands/dropbox.png';
import mail_chimp from '../../images/brands/mail_chimp.png';
import slack from '../../images/brands/slack.png';

import megamenu from '../../images/megamenu-img.png';

/**
 * Nav-bar Component
 */
export default {
    data() {
        return {
            logoDarkLg, logoDarkSm, logoLightLg, logoLightSm, avatar1, avatar3, avatar4, github, bitbucket, dribbble, dropbox, mail_chimp, slack, megamenu,
            languages: [
                {
                    flag: us,
                    language: "en",
                    title: "English",
                },
                {
                    flag: fr,
                    language: "fr",
                    title: "French",
                },
                {
                    flag: es,
                    language: "es",
                    title: "Spanish",
                },
                {
                    flag: zh,
                    language: "zh",
                    title: "Chinese",
                },
                {
                    flag: ar,
                    language: "ar",
                    title: "Arabic",
                },
            ],
            lan: this.$i18n.locale,
            text: null,
            flag: null,
            value: null,
            loggedInUser: JSON.parse(localStorage.getItem('user'))
        };
    },
    components: { simplebar },
    mounted() {
        this.value = this.languages.find((x) => x.language === this.$i18n.locale);
        this.text = this.value.title;
        this.flag = this.value.flag;
    },
    methods: {
        logout() {
            localStorage.clear();
            this.$router.push({ name: 'login' });
        },
        toggleMenu() {
            this.$parent.toggleMenu();
        },
        toggleRightSidebar() {
            this.$parent.toggleRightSidebar();
        },
        initFullScreen() {
            document.body.classList.toggle("fullscreen-enable");
            if (
                !document.fullscreenElement &&
        /* alternative standard method */ !document.mozFullScreenElement &&
                !document.webkitFullscreenElement
            ) {
                // current working methods
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(
                        Element.ALLOW_KEYBOARD_INPUT
                    );
                }
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                }
            }
        },
        setLanguage(locale, country, flag) {
            this.lan = locale;
            this.text = country;
            this.flag = flag;
            this.$i18n.locale = locale;
            localStorage.setItem("locale", locale);
        },
    },
};
</script>

<template>
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <router-link to="/" class="logo logo-dark">
                        <span class="logo-sm">
                            <img :src="logoDarkSm" alt height="22" />
                        </span>
                        <span class="logo-lg">
                            <img :src="logoDarkLg" alt height="17" />
                        </span>
                    </router-link>

                    <router-link to="/" class="logo logo-light">
                        <span class="logo-sm">
                            <img :src="logoLightSm" alt height="22" />
                        </span>
                        <span class="logo-lg">
                            <img :src="logoLightLg" alt height="19" />
                        </span>
                    </router-link>
                </div>

                <BButton variant="white" id="vertical-menu-btn" type="button"
                    class="btn btn-sm px-3 font-size-16 header-item" @click="toggleMenu">
                    <i class="fa fa-fw fa-bars"></i>
                </BButton>

                <!-- App Search-->
                <BForm class="app-search d-none d-lg-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" :placeholder="$t('navbar.search.text')" />
                        <span class="bx bx-search-alt"></span>
                    </div>
                </BForm>

                <BDropdown variant="black" class="dropdown-mega d-none d-lg-block ms-2" toggle-class="header-item"
                    menu-class="dropdown-megamenu dropdown-menu-end">
                    <template v-slot:button-content>
                        {{ $t('navbar.dropdown.megamenu.text') }}
                        <i class="mdi mdi-chevron-down"></i>
                    </template>

                    <BRow>
                        <BCol col="8">
                            <BRow>
                                <BCol md="4">
                                    <h5 class="font-size-14 mt-0">{{ $t('navbar.dropdown.megamenu.uicontent.title') }}
                                    </h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.uicontent.list.lightbox') }}
                                            </BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.uicontent.list.rangeslider')
                                            }}</BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.uicontent.list.sweetalert') }}
                                            </BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.uicontent.list.rating') }}
                                            </BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.uicontent.list.forms') }}
                                            </BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.uicontent.list.tables') }}
                                            </BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.uicontent.list.charts') }}
                                            </BLink>
                                        </li>
                                    </ul>
                                </BCol>

                                <BCol md="4">
                                    <h5 class="font-size-14 mt-0">{{ $t('navbar.dropdown.megamenu.application.title') }}
                                    </h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.application.list.ecommerce')
                                            }}</BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.application.list.calendar') }}
                                            </BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.application.list.email') }}
                                            </BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.application.list.projects') }}
                                            </BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.application.list.tasks') }}
                                            </BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.application.list.contacts') }}
                                            </BLink>
                                        </li>
                                    </ul>
                                </BCol>

                                <BCol md="4">
                                    <h5 class="font-size-14 mt-0">{{ $t('navbar.dropdown.megamenu.extrapages.title') }}
                                    </h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.extrapages.list.lightsidebar')
                                            }}</BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.extrapages.list.compactsidebar') }}</BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.extrapages.list.horizontallayout') }}
                                            </BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.extrapages.list.maintenance')
                                            }}</BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.extrapages.list.comingsoon')
                                            }}</BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.extrapages.list.timeline') }}
                                            </BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.extrapages.list.faqs') }}
                                            </BLink>
                                        </li>
                                    </ul>
                                </BCol>
                            </BRow>
                        </BCol>
                        <BCol sm="4">
                            <BRow>
                                <BCol sm="6">
                                    <h5 class="font-size-14 mt-0">{{ $t('navbar.dropdown.megamenu.uicontent.title') }}
                                    </h5>
                                    <ul class="list-unstyled megamenu-list">
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.uicontent.list.lightbox') }}
                                            </BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.uicontent.list.rangeslider')
                                            }}</BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.uicontent.list.sweetalert') }}
                                            </BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.uicontent.list.rating') }}
                                            </BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.uicontent.list.forms') }}
                                            </BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.uicontent.list.tables') }}
                                            </BLink>
                                        </li>
                                        <li>
                                            <BLink href="javascript:void(0);">{{
                                                $t('navbar.dropdown.megamenu.uicontent.list.charts') }}
                                            </BLink>
                                        </li>
                                    </ul>
                                </BCol>

                                <BCol sm="5">
                                    <div>
                                        <img :src="megamenu" alt class="img-fluid mx-auto d-block" />
                                    </div>
                                </BCol>
                            </BRow>
                        </BCol>
                    </BRow>
                </BDropdown>
            </div>

            <div class="d-flex">
                <BDropdown class="d-inline-block d-lg-none ms-2" variant="black" menu-class="dropdown-menu-lg p-0"
                    toggle-class="header-item noti-icon" right>
                    <template v-slot:button-content>
                        <i class="mdi mdi-magnify"></i>
                    </template>

                    <BForm class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search ..."
                                    aria-label="Recipient's username" />
                                <div class="input-group-append">
                                    <BButton class="btn btn-primary" type="submit">
                                        <i class="mdi mdi-magnify"></i>
                                    </BButton>
                                </div>
                            </div>
                        </div>
                    </BForm>
                </BDropdown>

                <!-- <BDropdown variant="white" right toggle-class="header-item">
                    <template v-slot:button-content>
                        <img class :src="flag" alt="Header Language" height="16" />
                    </template>
                    <BDropdownItem class="notify-item" v-for="(entry, i) in languages" :key="`Lang${i}`" :value="entry"
                        @click="setLanguage(entry.language, entry.title, entry.flag)"
                        :class="{ 'active': lan === entry.language }">
                        <img :src="`${entry.flag}`" alt="user-image" class="me-1" height="12" />
                        <span class="align-middle">{{ entry.title }}</span>
                    </BDropdownItem>
                </BDropdown> -->

                <!-- <BDropdown class="d-none d-lg-inline-block noti-icon" menu-class="dropdown-menu-lg dropdown-menu-end"
                    right toggle-class="header-item" variant="black">
                    <template v-slot:button-content>
                        <i class="bx bx-customize"></i>
                    </template>

                    <div class="px-lg-2">
                        <BRow class="no-gutters">
                            <BCol>
                                <BLink class="dropdown-icon-item" href="javascript:void(0);">
                                    <img :src="github" alt="Github" />
                                    <span>{{ $t('navbar.dropdown.site.list.github') }}</span>
                                </BLink>
                            </BCol>
                            <BCol>
                                <BLink class="dropdown-icon-item" href="javascript: void(0);">
                                    <img :src="bitbucket" alt="bitbucket" />
                                    <span>{{ $t('navbar.dropdown.site.list.github') }}</span>
                                </BLink>
                            </BCol>
                            <BCol>
                                <BLink class="dropdown-icon-item" href="javascript: void(0);">
                                    <img :src="dribbble" alt="dribbble" />
                                    <span>{{ $t('navbar.dropdown.site.list.dribbble') }}</span>
                                </BLink>
                            </BCol>
                        </BRow>

                        <div class="row no-gutters">
                            <BCol>
                                <BLink class="dropdown-icon-item" href="javascript: void(0);">
                                    <img :src="dropbox" alt="dropbox" />
                                    <span>{{ $t('navbar.dropdown.site.list.dropbox') }}</span>
                                </BLink>
                            </BCol>
                            <BCol>
                                <BLink class="dropdown-icon-item" href="javascript: void(0);">
                                    <img :src="mail_chimp" alt="mail_chimp" />
                                    <span>{{ $t('navbar.dropdown.site.list.mailchimp') }}</span>
                                </BLink>
                            </BCol>
                            <BCol>
                                <BLink class="dropdown-icon-item" href="javascript: void(0);">
                                    <img :src="slack" alt="slack" />
                                    <span>{{ $t('navbar.dropdown.site.list.slack') }}</span>
                                </BLink>
                            </BCol>
                        </div>
                    </div>
                </BDropdown> -->

                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <BButton variant="white" type="button" class="btn header-item noti-icon" @click="initFullScreen">
                        <i class="bx bx-fullscreen"></i>
                    </BButton>
                </div>

                <!-- <BDropdown right menu-class="dropdown-menu-lg p-0 dropdown-menu-end"
                    toggle-class="header-item noti-icon" variant="black">
                    <template v-slot:button-content>
                        <i class="bx bx-bell bx-tada"></i>
                        <span class="badge bg-danger rounded-pill">{{ $t('navbar.dropdown.notification.badge') }}</span>
                    </template>

                    <div class="p-3">
                        <BRow class="align-items-center">
                            <BCol>
                                <h6 class="m-0">{{ $t('navbar.dropdown.notification.text') }}</h6>
                            </BCol>
                            <div class="col-auto">
                                <BLink href="#" class="small">{{ $t('navbar.dropdown.notification.subtext') }}</BLink>
                            </div>
                        </BRow>
                    </div>
                    <simplebar style="max-height: 230px;">
                        <BLink href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="bx bx-cart"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mt-0 mb-1">{{ $t('navbar.dropdown.notification.order.title') }}</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">{{ $t('navbar.dropdown.notification.order.text') }}</p>
                                        <p class="mb-0">
                                            <i class="mdi mdi-clock-outline"></i>
                                            {{ $t('navbar.dropdown.notification.order.time') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </BLink>
                        <BLink href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <img :src="avatar3" class="me-3 rounded-circle avatar-xs" alt="user-pic" />
                                <div class="flex-grow-1">
                                    <h6 class="mt-0 mb-1">{{ $t('navbar.dropdown.notification.james.title') }}</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">{{ $t('navbar.dropdown.notification.james.text') }}</p>
                                        <p class="mb-0">
                                            <i class="mdi mdi-clock-outline"></i>
                                            {{ $t('navbar.dropdown.notification.james.time') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </BLink>
                        <BLink href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                        <i class="bx bx-badge-check"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mt-0 mb-1">{{ $t('navbar.dropdown.notification.item.title') }}</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">{{ $t('navbar.dropdown.notification.item.text') }}</p>
                                        <p class="mb-0">
                                            <i class="mdi mdi-clock-outline"></i>
                                            {{ $t('navbar.dropdown.notification.item.time') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </BLink>
                        <BLink href="javascript: void(0);" class="text-reset notification-item">
                            <div class="d-flex">
                                <img :src="avatar4" class="me-3 rounded-circle avatar-xs" alt="user-pic" />
                                <div class="flex-grow-1">
                                    <h6 class="mt-0 mb-1">{{ $t('navbar.dropdown.notification.salena.title') }}</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">{{ $t('navbar.dropdown.notification.salena.text') }}</p>
                                        <p class="mb-0">
                                            <i class="mdi mdi-clock-outline"></i>
                                            {{ $t('navbar.dropdown.notification.salena.time') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </BLink>
                    </simplebar>
                    <div class="p-2 border-top d-grid">
                        <BLink class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                            <i class="mdi mdi-arrow-down-circle me-1"></i>
                            <span key="t-view-more"> {{ $t('navbar.dropdown.notification.button') }} </span>
                        </BLink>
                    </div>
                </BDropdown> -->

                <BDropdown right variant="black" toggle-class="header-item" menu-class="dropdown-menu-end">
                    <template v-slot:button-content>
                        <img class="rounded-circle header-profile-user" :src="avatar1" alt="Header Avatar" />
                        <span class="d-none d-xl-inline-block ms-1">{{ this.loggedInUser.name }}</span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                    </template>
                    <!-- item-->

                    <BDropdownItem>
                        <router-link to="/contacts/profile">
                            <i class="bx bx-user font-size-16 align-middle me-1"></i>
                            {{ $t('navbar.dropdown.henry.list.profile') }}
                        </router-link>
                    </BDropdownItem>
                    <!-- <BDropdownItem href="javascript: void(0);">
                        <i class="bx bx-wallet font-size-16 align-middle me-1"></i>
                        {{ $t('navbar.dropdown.henry.list.mywallet') }}
                    </BDropdownItem> -->
                    <!-- <BDropdownItem class="d-block" href="javascript: void(0);">
                        <span class="badge bg-success float-end">11</span>
                        <i class="bx bx-wrench font-size-16 align-middle me-1"></i>
                        {{ $t('navbar.dropdown.henry.list.settings') }}
                    </BDropdownItem> -->
                    <BDropdownItem href="javascript: void(0);">
                        <i class="bx bx-lock-open font-size-16 align-middle me-1"></i>
                        {{ $t('navbar.dropdown.henry.list.lockscreen') }}
                    </BDropdownItem>
                    <BDropdownDivider></BDropdownDivider>
                    <BLink href="javascript:void(0)" @click="logout()" class="dropdown-item text-danger">
                        <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                        {{ $t('navbar.dropdown.henry.list.logout') }}
                    </BLink>
                </BDropdown>

                <div class="dropdown d-inline-block">
                    <BButton variant="white" type="button"
                        class="btn header-item noti-icon right-bar-toggle toggle-right" @click="toggleRightSidebar">
                        <i class="bx bx-cog bx-spin toggle-right"></i>
                    </BButton>
                </div>
            </div>
        </div>
    </header>
</template>

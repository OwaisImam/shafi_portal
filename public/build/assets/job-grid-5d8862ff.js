import{L as S}from"./main-29c7ebb4.js";import{P as D}from"./page-header-5e34e666.js";import{P as E}from"./pagination-8da4822a.js";import{C as Y}from"./flatpickr-5a27b0d4.js";import{c as M,a as Q,b as V,f as J,m as I,l as A,d as j,s as G,r as H}from"./spotify-eb9e2ee9.js";import{a as N}from"./adobe-photoshop-834272c6.js";import{_ as q,r as a,g as R,c as v,w as t,o as f,a as e,b as o,d as l,h as z,e as K,f as O,F as W,t as d}from"../js/app2.js";import"./logo-light-deb27e23.js";import"./logo-9faa3827.js";import"./avatar-1-15b743f1.js";import"./avatar-3-36dc574b.js";const X="/build/icons/upwork.svg",Z="/build/icons/wordpress.svg",k=[{id:1,title:"Magento Developer",experience:"(0-2 Yrs Exp)",company:"Skote Technology Pvt.Ltd",location:"California",salary:"$250 - $800 / month",employmentType:"Full Time",urgency:"Urgent",privacy:"Private",imageUrl:M},{id:2,title:"Product Designer",experience:"(0-2 Yrs Exp)",company:"Skote Technology Pvt.Ltd",location:"California",salary:"$250 - $800 / month",employmentType:"Full Time",urgency:"Urgent",privacy:"Private",imageUrl:N},{id:3,title:"Marketing Director",experience:"(0-2 Yrs Exp)",company:"Skote Technology Pvt.Ltd",location:"California",salary:"$250 - $800 / month",employmentType:"Full Time",urgency:"Urgent",privacy:"Private",imageUrl:Q},{id:4,title:"Project Manager",experience:"(0-2 Yrs Exp)",company:"Skote Technology Pvt.Ltd",location:"California",salary:"$250 - $800 / month",employmentType:"Full Time",urgency:"Urgent",privacy:"Private",imageUrl:V},{id:5,title:"HTML Developer",experience:"(0-2 Yrs Exp)",company:"Skote Technology Pvt.Ltd",location:"California",salary:"$250 - $800 / month",employmentType:"Full Time",urgency:"Urgent",privacy:"Private",imageUrl:J},{id:6,title:"Business Associate",experience:"(0-2 Yrs Exp)",company:"Skote Technology Pvt.Ltd",location:"California",salary:"$250 - $800 / month",employmentType:"Full Time",urgency:"Urgent",privacy:"Private",imageUrl:I},{id:7,title:"Product Sales Specialist",experience:"(0-2 Yrs Exp)",company:"Skote Technology Pvt.Ltd",location:"California",salary:"$250 - $800 / month",employmentType:"Full Time",urgency:"Urgent",privacy:"Private",imageUrl:A},{id:8,title:"Magento Developer",experience:"(0-2 Yrs Exp)",company:"Skote Technology Pvt.Ltd",location:"California",salary:"$250 - $800 / month",employmentType:"Full Time",urgency:"Urgent",privacy:"Private",imageUrl:j},{id:9,title:"Magento Developer",experience:"(0-2 Yrs Exp)",company:"Skote Technology Pvt.Ltd",location:"California",salary:"$250 - $800 / month",employmentType:"Full Time",urgency:"Urgent",privacy:"Private",imageUrl:Z},{id:10,title:"Magento Developer",experience:"(0-2 Yrs Exp)",company:"Skote Technology Pvt.Ltd",location:"California",salary:"$250 - $800 / month",employmentType:"Full Time",urgency:"Urgent",privacy:"Private",imageUrl:X},{id:11,title:"Magento Developer",experience:"(0-2 Yrs Exp)",company:"Skote Technology Pvt.Ltd",location:"California",salary:"$250 - $800 / month",employmentType:"Full Time",urgency:"Urgent",privacy:"Private",imageUrl:G},{id:11,title:"Magento Developer",experience:"(0-2 Yrs Exp)",company:"Skote Technology Pvt.Ltd",location:"California",salary:"$250 - $800 / month",employmentType:"Full Time",urgency:"Urgent",privacy:"Private",imageUrl:H}],ee={components:{Layout:S,PageHeader:D,flatPickr:Y,Pagination:E},data(){return{jobData:k,searchQuery:null,defaultDateConfig:{dateFormat:"d M, Y",defaultDate:"25 Dec, 2021"},page:1,perPage:7,resultQuery:k}},watch:{searchQuery(p){if(p){const s=p.toLowerCase();this.resultQuery=this.displayedPosts.filter(c=>c.title.toLowerCase().includes(s)||c.location.toLowerCase().includes(s)||c.company.toLowerCase().includes(s))}else this.resultQuery=this.displayedPosts}},computed:{displayedPosts(){return this.jobData}},methods:{paginate(p){let s=this.page,c=this.perPage,x=s*c-c,m=s*c;return p.slice(x,m)}}},te={class:"position-relative"},oe={class:"position-relative"},le={class:"position-relative"},ae={class:"position-relative"},ie={class:"position-relative h-100 hstack gap-3"},ne=o("i",{class:"bx bx-search-alt align-middle"},null,-1),se=o("i",{class:"bx bx-filter-alt align-middle"},null,-1),re={class:"pt-4"},ce=o("label",{for:"experience",class:"form-label d-flex"},"Experience",-1),de=o("label",{for:"jobType",class:"form-label d-flex"},"Job Type",-1),pe=o("div",{class:"position-relative form-group"},[o("label",{for:"qualificationInput",class:"form-label"},"Qualification"),o("input",{type:"text",class:"form-control",id:"qualificationInput",autocomplete:"off",placeholder:"Qualification"}),o("i",{class:"ri-government-line filter-icon"})],-1),me={class:"favorite-icon"},ue=o("i",{class:"uil uil-heart-alt fs-18"},null,-1),_e=["src"],fe={class:"fs-17 mb-2"},ye={class:"text-muted fw-normal"},ge={class:"list-inline mb-0"},he={class:"list-inline-item"},ve={class:"text-muted fs-14 mb-1"},xe={class:"list-inline-item"},be={class:"text-muted fs-14 mb-0"},ke=o("i",{class:"mdi mdi-map-marker"},null,-1),Ce={class:"list-inline-item"},Te={class:"text-muted fs-14 mb-0"},Pe=o("i",{class:"uil uil-wallet"},null,-1),Be={class:"mt-3 hstack gap-2"},Fe={class:"badge rounded-1 badge-soft-success"},Ue={class:"badge rounded-1 badge-soft-warning"},Le={class:"badge rounded-1 badge-soft-info"},we={class:"mt-4 hstack gap-2"},$e=o("p",{class:"text-muted mb-0"},[l("Showing "),o("b",null,"1"),l(" to "),o("b",null,"12"),l(" of "),o("b",null,"45"),l(" entries")],-1),Se={"aria-label":"Page navigation example",class:"mb-0"};function De(p,s,c,x,m,Ee){const C=a("PageHeader"),y=a("BFormInput"),n=a("BCol"),T=a("flat-pickr"),P=a("BButton"),_=a("BLink"),r=a("BFormCheckbox"),b=a("BFormCheckboxGroup"),u=a("BRow"),B=a("BCollapse"),F=a("BForm"),g=a("BCardBody"),h=a("BCard"),U=a("Blink"),L=a("pagination"),w=a("Layout"),$=R("b-toggle");return f(),v(w,null,{default:t(()=>[e(C,{title:"Jobs Grid",pageTitle:"Jobs"}),e(u,null,{default:t(()=>[e(n,{lg:"12"},{default:t(()=>[e(h,{"no-body":"",class:"job-filter"},{default:t(()=>[e(g,{class:"p-3"},{default:t(()=>[e(F,{action:"javascript:void(0);"},{default:t(()=>[e(u,{class:"g-3"},{default:t(()=>[e(n,{xxl:"4",lg:"4"},{default:t(()=>[o("div",te,[e(y,{type:"text",class:"form-control",id:"searchJob",autocomplete:"off",placeholder:"Search your job",modelValue:m.searchQuery,"onUpdate:modelValue":s[0]||(s[0]=i=>m.searchQuery=i)},null,8,["modelValue"])])]),_:1}),e(n,{xxl:"2",lg:"4"},{default:t(()=>[o("div",oe,[e(y,{type:"text",class:"form-control",id:"locationInput",autocomplete:"off",placeholder:"San Francisco, LA"})])]),_:1}),e(n,{xxl:"2",lg:"4"},{default:t(()=>[o("div",le,[e(y,{type:"text",class:"form-control",id:"jobCategories",autocomplete:"off",placeholder:"Job Categories"})])]),_:1}),e(n,{xxl:"2",lg:"6"},{default:t(()=>[o("div",ae,[e(T,{modelValue:p.date6,"onUpdate:modelValue":s[1]||(s[1]=i=>p.date6=i),config:m.defaultDateConfig,class:"form-control",placeholder:"Select date"},null,8,["modelValue","config"])])]),_:1}),e(n,{xxl:"2",lg:"6"},{default:t(()=>[o("div",ie,[e(P,{variant:"primary",type:"submit",class:"h-100 w-100"},{default:t(()=>[ne,l(" Find Jobs")]),_:1}),z((f(),v(_,{"data-bs-toggle":"collapse",class:"btn btn-secondary h-100 w-100"},{default:t(()=>[se,l(" Advance")]),_:1})),[[$,void 0,void 0,{collapseExample:!0}]])])]),_:1}),e(B,{id:"collapseExample",class:"mt-4"},{default:t(()=>[o("div",re,[e(u,{class:"g-3"},{default:t(()=>[e(n,{xxl:"4",lg:"6"},{default:t(()=>[e(b,null,{default:t(()=>[ce,e(r,{id:"inlineCheckbox1",value:"option1"},{default:t(()=>[l("All")]),_:1}),e(r,{id:"inlineCheckbox2",value:"option1"},{default:t(()=>[l("Fresher")]),_:1}),e(r,{id:"inlineCheckbox3",value:"option2"},{default:t(()=>[l("1-2")]),_:1}),e(r,{id:"inlineCheckbox4",value:"option2"},{default:t(()=>[l("2-3")]),_:1}),e(r,{id:"inlineCheckbox5",value:"option3"},{default:t(()=>[l("4+")]),_:1})]),_:1})]),_:1}),e(n,{xxl:"4",lg:"6"},{default:t(()=>[e(b,null,{default:t(()=>[de,e(r,{id:"inlineCheckbox6",value:"option3"},{default:t(()=>[l("Full Time")]),_:1}),e(r,{id:"inlineCheckbox7",value:"option3"},{default:t(()=>[l("Part Time")]),_:1}),e(r,{id:"inlineCheckbox8",value:"option3"},{default:t(()=>[l("Freelance")]),_:1}),e(r,{id:"inlineCheckbox9",value:"option3"},{default:t(()=>[l("Internship")]),_:1})]),_:1})]),_:1}),e(n,{xxl:"4",lg:"4"},{default:t(()=>[pe]),_:1})]),_:1})])]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1}),e(u,{id:"jobgrid-list"},{default:t(()=>[(f(!0),K(W,null,O(m.resultQuery,i=>(f(),v(n,{xl:"3",md:"6",key:i.id},{default:t(()=>[e(h,{"no-body":""},{default:t(()=>[e(g,null,{default:t(()=>[o("div",me,[e(_,{href:"javascript:void(0)"},{default:t(()=>[ue]),_:1})]),o("img",{src:i.imageUrl,alt:"",height:"50",class:"mb-3"},null,8,_e),o("h5",fe,[e(_,{href:"javascript:void(0);",class:"text-dark"},{default:t(()=>[l(d(i.title),1)]),_:2},1024),l(),o("small",ye,d(i.experience),1)]),o("ul",ge,[o("li",he,[o("p",ve,d(i.company),1)]),o("li",xe,[o("p",be,[ke,l(" "+d(i.location),1)])]),o("li",Ce,[o("p",Te,[Pe,l(" "+d(i.salary),1)])])]),o("div",Be,[o("span",Fe,d(i.employmentType),1),o("span",Ue,d(i.urgency),1),o("span",Le,d(i.privacy),1)]),o("div",we,[e(_,{href:"#!","data-bs-toggle":"modal",class:"btn btn-soft-success w-100"},{default:t(()=>[l("View Profile")]),_:1}),e(U,{href:"#applyJobs","data-bs-toggle":"modal",class:"btn btn-soft-primary w-100"},{default:t(()=>[l("Apply Now")]),_:1})])]),_:2},1024)]),_:2},1024)]),_:2},1024))),128))]),_:1}),e(u,{class:"justify-content-between align-items-center mb-3"},{default:t(()=>[e(n,{class:"col-auto me-auto"},{default:t(()=>[$e]),_:1}),e(n,{class:"col-auto"},{default:t(()=>[e(h,{"no-body":"",class:"d-inline-block ms-auto mb-0"},{default:t(()=>[e(g,{class:"p-0"},{default:t(()=>[o("nav",Se,[e(L)])]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})}const qe=q(ee,[["render",De]]);export{qe as default};

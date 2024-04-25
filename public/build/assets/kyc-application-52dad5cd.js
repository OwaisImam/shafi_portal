import{L as F}from"./main-29c7ebb4.js";import{P as V}from"./page-header-5e34e666.js";import{D as k}from"./dropZone-cfaf1e35.js";import{_ as w,z as E,r as a,c as Y,w as o,o as P,a as t,b as e,d as _,n as d,p as z,t as h}from"../js/app2.js";import{u as A}from"./index-2342d801.js";import"./logo-light-deb27e23.js";import"./logo-9faa3827.js";import"./avatar-1-15b743f1.js";import"./avatar-3-36dc574b.js";const I="/build/icons/verification-img.png",L={methods:{onComplete:function(){this.$refs.iswizard.reset()},toggleTab(r){this.activeTab=r},toggleVerticalTab(r){this.activeVerticalTab=r}},components:{Layout:F,PageHeader:V,DropZone:k},setup(){let r=E("");return{dropzoneFile:r,drop:u=>{r.value=u.dataTransfer.files[0]},selectedFile:()=>{r.value=document.querySelector(".dropzoneFile").files[0]},v$:A()}},data(){return{activeTab:1,activeVerticalTab:1,showModal:!1,verification:I}}},M={class:"text-center"},S=e("h4",{class:"mt-4 fw-semibold"},"KYC Verification",-1),U=e("p",{class:"text-muted mt-3"}," Itaque earum rerum hic tenetur a sapiente delectus ut aut reiciendis perferendis asperiores repellat. ",-1),j={class:"mt-4"},H=["src"],Z={id:"basic-example",role:"application",class:"wizard clearfix"},q={class:"steps clearfix"},K={role:"tablist"},R=e("a",{id:"basic-example-t-0",href:"#","aria-controls":"basic-example-p-0"},[e("span",{class:"number"},"1."),_(" Personal info")],-1),G=[R],J=e("a",{id:"basic-example-t-1",href:"#","aria-controls":"basic-example-p-1"},[e("span",{class:"number"},"2."),_(" Confirm email")],-1),O=[J],Q=e("a",{id:"basic-example-t-2",href:"#","aria-controls":"basic-example-p-2"},[e("span",{class:"number"},"3."),_(" Document verification")],-1),W=[Q],X={class:"content clearfix"},$=e("h3",{id:"basic-example-h-0",tabindex:"-1",class:"title current"},"Seller Details",-1),ee={class:"mb-3"},te=e("label",{for:"basicpill-firstname-input"},"First name",-1),oe={class:"mb-3"},le=e("label",{for:"basicpill-lastname-input"},"Last name",-1),se={class:"mb-3"},ie=e("label",{for:"basicpill-phoneno-input"},"Phone",-1),ae={class:"mb-3"},ne=e("label",{for:"basicpill-email-input"},"Email",-1),ce={class:"mb-3"},re=e("label",{for:"basicpill-address-input"},"Address",-1),de=e("h3",{id:"basic-example-h-1",tabindex:"-1",class:"title"},"Company Document",-1),pe={class:"mb-3"},_e=e("label",{for:"basicpill-pancard-input"},"PAN Card",-1),ue={class:"mb-3"},me=e("label",{for:"basicpill-vatno-input"},"VAT/TIN No.",-1),be={class:"mb-3"},fe=e("label",{for:"basicpill-cstno-input"},"CST No.",-1),he={class:"mb-3"},ve=e("label",{for:"basicpill-servicetax-input"},"Service Tax No.",-1),xe={class:"mb-3"},Te=e("label",{for:"basicpill-companyuin-input"},"Company UIN",-1),ge={class:"mb-3"},ye=e("label",{for:"basicpill-declaration-input"},"Declaration",-1),Ce=e("h3",{id:"basic-example-h-2",tabindex:"-1",class:"title"},"Bank Details",-1),Be=e("h5",{class:"font-size-14 mb-3"},"Upload document file for a verification",-1),Ne={class:"file-info"},De={class:"actions clearfix"},Fe={role:"menu","aria-label":"Pagination"};function Ve(r,s,v,u,l,m){const x=a("PageHeader"),T=a("BButton"),i=a("BCol"),c=a("BRow"),g=a("BCardBody"),y=a("BCard"),n=a("BFormInput"),C=a("BFormTextarea"),b=a("BForm"),B=a("DropZone"),f=a("BLink"),N=a("BModal"),D=a("Layout");return P(),Y(D,null,{default:o(()=>[t(x,{title:"KYC Application",pageTitle:"Crypto"}),t(c,{class:"justify-content-center mt-lg-5"},{default:o(()=>[t(i,{xl:"5",sm:"8"},{default:o(()=>[t(y,{"no-body":""},{default:o(()=>[t(g,null,{default:o(()=>[e("div",M,[t(c,{class:"justify-content-center"},{default:o(()=>[t(i,{lg:"10"},{default:o(()=>[S,U,e("div",j,[t(T,{variant:"primary",onClick:s[0]||(s[0]=p=>l.showModal=!0)},{default:o(()=>[_(" Click here for Verification ")]),_:1})])]),_:1}),t(c,{class:"justify-content-center mt-5 mb-2"},{default:o(()=>[t(i,{sm:"6",cols:"8"},{default:o(()=>[e("div",null,[e("img",{src:l.verification,alt:"",class:"img-fluid"},null,8,H)])]),_:1})]),_:1})]),_:1})])]),_:1})]),_:1})]),_:1})]),_:1}),t(N,{modelValue:l.showModal,"onUpdate:modelValue":s[6]||(s[6]=p=>l.showModal=p),size:"lg",centered:"",title:"Verify your Account","hide-footer":""},{default:o(()=>[e("div",Z,[e("div",q,[e("ul",K,[e("li",{role:"tab",class:d({current:l.activeTab==1,done:l.activeTab>1}),onClick:s[1]||(s[1]=p=>{m.toggleTab(1)})},G,2),e("li",{role:"tab",class:d({current:l.activeTab==2,done:l.activeTab>2}),onClick:s[2]||(s[2]=p=>{m.toggleTab(2)})},O,2),e("li",{role:"tab",class:d({current:l.activeTab==3,done:l.activeTab>3}),onClick:s[3]||(s[3]=p=>{m.toggleTab(3)})},W,2)])]),e("div",X,[$,e("section",{id:"basic-example-p-0",role:"tabpanel",class:d(l.activeTab==1?"body current":"d-none")},[t(b,null,{default:o(()=>[t(c,null,{default:o(()=>[t(i,{lg:"6"},{default:o(()=>[e("div",ee,[te,t(n,{type:"text",class:"form-control",id:"basicpill-firstname-input",placeholder:"Enter Your First Name"})])]),_:1}),t(i,{lg:"6"},{default:o(()=>[e("div",oe,[le,t(n,{type:"text",class:"form-control",id:"basicpill-lastname-input",placeholder:"Enter Your Last Name"})])]),_:1})]),_:1}),t(c,null,{default:o(()=>[t(i,{lg:"6"},{default:o(()=>[e("div",se,[ie,t(n,{type:"text",class:"form-control",id:"basicpill-phoneno-input",placeholder:"Enter Your Phone No."})])]),_:1}),t(i,{lg:"6"},{default:o(()=>[e("div",ae,[ne,t(n,{type:"email",class:"form-control",id:"basicpill-email-input",placeholder:"Enter Your Email ID"})])]),_:1})]),_:1}),t(c,null,{default:o(()=>[t(i,{lg:"12"},{default:o(()=>[e("div",ce,[re,t(C,{id:"basicpill-address-input",class:"form-control",rows:"2",placeholder:"Enter Your Address"})])]),_:1})]),_:1})]),_:1})],2),de,e("section",{id:"basic-example-p-1",role:"tabpanel",class:d(l.activeTab==2?"body current":"d-none")},[t(b,null,{default:o(()=>[t(c,null,{default:o(()=>[t(i,{lg:"6"},{default:o(()=>[e("div",pe,[_e,t(n,{type:"text",class:"form-control",id:"basicpill-pancard-input",placeholder:"Enter Your PAN No."})])]),_:1}),t(i,{lg:"6"},{default:o(()=>[e("div",ue,[me,t(n,{type:"text",class:"form-control",id:"basicpill-vatno-input",placeholder:"Enter Your VAT/TIN No."})])]),_:1})]),_:1}),t(c,null,{default:o(()=>[t(i,{lg:"6"},{default:o(()=>[e("div",be,[fe,t(n,{type:"text",class:"form-control",id:"basicpill-cstno-input",placeholder:"Enter Your CST No."})])]),_:1}),t(i,{lg:"6"},{default:o(()=>[e("div",he,[ve,t(n,{type:"text",class:"form-control",id:"basicpill-servicetax-input",placeholder:"Enter Your Service Tax No."})])]),_:1})]),_:1}),t(c,null,{default:o(()=>[t(i,{lg:"6"},{default:o(()=>[e("div",xe,[Te,t(n,{type:"text",class:"form-control",id:"basicpill-companyuin-input",placeholder:"Enter Your Company UIN"})])]),_:1}),t(i,{lg:"6"},{default:o(()=>[e("div",ge,[ye,t(n,{type:"text",class:"form-control",id:"basicpill-Declaration-input",placeholder:"Declaration Details"})])]),_:1})]),_:1})]),_:1})],2),Ce,e("section",{id:"basic-example-p-2",role:"tabpanel",class:d(l.activeTab==3?"body current":"d-none")},[e("div",null,[Be,t(B,{onDrop:z(u.drop,["prevent"]),onChange:u.selectedFile},null,8,["onDrop","onChange"]),e("span",Ne,h(u.dropzoneFile.name),1)])],2)]),e("div",De,[e("ul",Fe,[e("li",{class:d({disabled:l.activeTab<=1})},[t(f,{href:"#",disabled:l.activeTab<=1,onClick:s[4]||(s[4]=p=>l.activeTab--)},{default:o(()=>[_("Previous")]),_:1},8,["disabled"])],2),e("li",{class:d({disabled:l.activeTab==3})},[t(f,{href:"#",disabled:l.activeTab==3,onClick:s[5]||(s[5]=p=>l.activeTab++)},{default:o(()=>[_(h(l.activeTab==4?"Finish":"Next"),1)]),_:1},8,["disabled"])],2)])])])]),_:1},8,["modelValue"])]),_:1})}const Me=w(L,[["render",Ve]]);export{Me as default};

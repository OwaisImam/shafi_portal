import{L}from"./main-29c7ebb4.js";import{P as N}from"./page-header-5e34e666.js";import{P as F}from"./pagination-8da4822a.js";import{_ as S,r as a,c as v,w as t,o as i,a as e,b as o,d as l,e as p,f as V,F as H,t as d,s as r}from"../js/app2.js";import"./logo-light-deb27e23.js";import"./logo-9faa3827.js";import"./avatar-1-15b743f1.js";import"./avatar-3-36dc574b.js";const W=[{title:"Magento Developer",company:"Creative Agency",type:"Full Time",datePosted:"02 June 2021",status:"Active"},{title:"Apple School & College",company:"Themesbrand",type:"Part Time",datePosted:"15 June 2021",status:"New"},{title:"Marketing Director",company:"Web Technology pvt.Ltd",type:"Full Time",datePosted:"02 June 2021",status:"Close"},{title:"HTML Developer",company:"Skote Technology pvt.Ltd",type:"Full Time",datePosted:"02 June 2021",status:"Active"},{title:"Product Sales Specialist",company:"New Technology pvt.Ltd",type:"Part Time",datePosted:"25 June 2021",status:"New"},{title:"Magento Developer",company:"Themesbrand",type:"Freelance",datePosted:"25 June 2021",status:"Close"},{title:"Magento Developer",company:"Web Technology pvt.Ltd",type:"Part Time",datePosted:"25 June 2021",status:"Active"},{title:"Magento Developer",company:"Web Technology pvt.Ltd",type:"Full Time",datePosted:"25 June 2021",status:"Close"},{title:"Magento Developer",company:"Adobe Agency",type:"Freelance",datePosted:"25 June 2021",status:"New"},{title:"Magento Developer",company:"Web Technology pvt.Ltd",type:"Internship",datePosted:"02 June 2021",status:"Active"}],z={components:{Layout:L,PageHeader:N,Pagination:F},data(){return{jobapply:W,showModal:!1}}},I={class:"d-flex align-items-center"},R=o("div",{class:"flex-shrink-0"},[o("select",{class:"form-select","aria-label":"Default select example"},[o("option",{value:"Today",selected:""},"Today"),o("option",{value:"1 MonBThly"},"1 MonBTh"),o("option",{value:"6 MonBTh"},"6 MonBTh"),o("option",{value:"1 Years"},"1 Year")])],-1),Y={class:"table-responsive"},E={key:0,class:"badge badge-soft-success"},U={key:1,class:"badge badge-soft-danger"},q={key:2,class:"badge badge-soft-info"},G={key:3,class:"badge badge-soft-warning"},K={key:0,class:"badge bg-success"},O={key:1,class:"badge bg-info"},Q={key:2,class:"badge bg-danger"},X={class:"list-unstyled hstack gap-1 mb-0"},Z={"data-bs-toggle":"tooltip","data-bs-placement":"top",title:"View"},$=o("i",{class:"mdi mdi-eye-outline"},null,-1),j={"data-bs-toggle":"tooltip","data-bs-placement":"top",title:"Delete"},ee=o("i",{class:"mdi mdi-delete-outline"},null,-1),te=o("p",{class:"text-muted mb-0"},[l("Showing "),o("b",null,"1"),l(" to "),o("b",null,"12"),l(" of "),o("b",null,"45"),l(" entries")],-1),oe={"aria-label":"Page navigation example",class:"mb-0"},se=o("div",{class:"avatar-sm mb-4 mx-auto"},[o("div",{class:"avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3"},[o("i",{class:"mdi mdi-trash-can-outline"})])],-1),ae=o("p",{class:"text-muted font-size-16 mb-4"},"Are you sure you want to permanently erase BThe job.",-1),le={class:"hstack gap-2 justify-content-center mb-0"};function ne(de,c,ce,ie,n,pe){const B=a("PageHeader"),w=a("BCardTitle"),m=a("BCardBody"),u=a("BTh"),b=a("BTr"),k=a("BThead"),_=a("BTd"),M=a("router-link"),C=a("BLink"),P=a("BTbody"),x=a("BTableSimple"),y=a("BCol"),A=a("pagination"),g=a("BCard"),h=a("BRow"),f=a("BButton"),D=a("BModal"),J=a("Layout");return i(),v(J,null,{default:t(()=>[e(B,{title:"Job Apply",pageTitle:"Jobs"}),e(h,null,{default:t(()=>[e(y,{lg:"12"},{default:t(()=>[e(g,{"no-body":""},{default:t(()=>[e(m,{class:"border-bottom"},{default:t(()=>[o("div",I,[e(w,{class:"mb-0 flex-grow-1"},{default:t(()=>[l("Applied Jobs")]),_:1}),R])]),_:1}),e(m,null,{default:t(()=>[o("div",Y,[e(x,{class:"table-bordered align-middle nowrap"},{default:t(()=>[e(k,null,{default:t(()=>[e(b,null,{default:t(()=>[e(u,{scope:"col"},{default:t(()=>[l("No")]),_:1}),e(u,{scope:"col"},{default:t(()=>[l("Job Title")]),_:1}),e(u,{scope:"col"},{default:t(()=>[l("Company Name")]),_:1}),e(u,{scope:"col"},{default:t(()=>[l("Type")]),_:1}),e(u,{scope:"col"},{default:t(()=>[l("Apply Date")]),_:1}),e(u,{scope:"col"},{default:t(()=>[l("Status")]),_:1}),e(u,{scope:"col"},{default:t(()=>[l("Action")]),_:1})]),_:1})]),_:1}),e(P,null,{default:t(()=>[(i(!0),p(H,null,V(n.jobapply,(s,T)=>(i(),v(b,{key:T},{default:t(()=>[e(_,null,{default:t(()=>[l(d(T+1),1)]),_:2},1024),e(_,null,{default:t(()=>[l(d(s.title),1)]),_:2},1024),e(_,null,{default:t(()=>[l(d(s.company),1)]),_:2},1024),e(_,null,{default:t(()=>[s.type==="Full Time"?(i(),p("span",E,d(s.type),1)):r("",!0),s.type==="Part Time"?(i(),p("span",U,d(s.type),1)):r("",!0),s.type==="Freelance"?(i(),p("span",q,d(s.type),1)):r("",!0),s.type==="Internship"?(i(),p("span",G,d(s.type),1)):r("",!0)]),_:2},1024),e(_,null,{default:t(()=>[l(d(s.datePosted),1)]),_:2},1024),e(_,null,{default:t(()=>[s.status==="Active"?(i(),p("span",K,d(s.status),1)):r("",!0),s.status==="New"?(i(),p("span",O,d(s.status),1)):r("",!0),s.status==="Close"?(i(),p("span",Q,d(s.status),1)):r("",!0)]),_:2},1024),o("td",null,[o("ul",X,[o("li",Z,[e(M,{to:"/jobs/details",class:"btn btn-sm btn-soft-primary"},{default:t(()=>[$]),_:1})]),o("li",j,[e(C,{href:"#jobDelete",onClick:c[0]||(c[0]=ue=>n.showModal=!n.showModal),class:"btn btn-sm btn-soft-danger"},{default:t(()=>[ee]),_:1})])])])]),_:2},1024))),128))]),_:1})]),_:1})]),e(h,{class:"justify-content-between align-items-center"},{default:t(()=>[e(y,{class:"col-auto me-auto"},{default:t(()=>[te]),_:1}),e(y,{class:"col-auto"},{default:t(()=>[e(g,{"no-body":"",class:"d-inline-block mb-0"},{default:t(()=>[e(m,{class:"p-0"},{default:t(()=>[o("nav",oe,[e(A,{pills:!1})])]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1}),e(D,{modelValue:n.showModal,"onUpdate:modelValue":c[4]||(c[4]=s=>n.showModal=s),"title-class":"text-black font-18","body-class":"px-4 py-5 text-center","hide-header":"","hide-footer":"",class:"v-modal-custom",size:"sm",centered:""},{default:t(()=>[e(f,{type:"button",class:"btn-close position-absolute end-0 top-0 m-3",onClick:c[1]||(c[1]=s=>n.showModal=!n.showModal)}),se,ae,o("div",le,[e(f,{variant:"danger",onClick:c[2]||(c[2]=s=>n.showModal=!n.showModal)},{default:t(()=>[l("Delete Now")]),_:1}),e(f,{variant:"secondary",onClick:c[3]||(c[3]=s=>n.showModal=!n.showModal),type:"button",class:"btn btn-secondary"},{default:t(()=>[l("Close")]),_:1})])]),_:1},8,["modelValue"])]),_:1})}const Te=S(z,[["render",ne]]);export{Te as default};

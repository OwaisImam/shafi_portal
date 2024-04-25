import{a as F}from"./axios-4d564c32.js";import{D as S}from"./dropZone-cfaf1e35.js";import{_ as U,z,r as l,c as I,w as n,o as i,a,d as u,e as c,F as L,f as H,s as f,p as P,b as e,h as b,q as y,n as B,t as M}from"../js/app2.js";import{u as Z}from"./index-2342d801.js";import{s as E}from"./multiselect-d5285c27.js";import{L as K}from"./main-29c7ebb4.js";import{P as R}from"./page-header-5e34e666.js";import"./logo-light-deb27e23.js";import"./logo-9faa3827.js";import"./avatar-1-15b743f1.js";import"./avatar-3-36dc574b.js";const W={components:{Multiselect:E,Layout:K,PageHeader:R,DropZone:S},data(){return{formData:new FormData,product:{name:"",manufacture_name:"",manufacture_brand:"",price:null},image:"",file:"",value:null,value1:null,options:["Alaska","Hawaii","California","Nevada","Oregon","Washington","Arizona","Colorado","Idaho","Montana","Nebraska","New Mexico","North Dakota","Utah","Wyoming","Alabama","Arkansas","Illinois","Iowa"],submitted:!1,formData:{name:null,manufacture_name:null,manufacture_brand:null,price:null,image:null},avatar:null,avatarName:null,showForm:!0,user:null,errors:null}},setup(){let t=z("");return{dropzoneFile:t,drop:d=>{t.value=d.dataTransfer.files[0]},selectedFile:()=>{t.value=document.querySelector(".dropzoneFile").files[0]},v$:Z()}},methods:{onAccept(t){this.image=t.name,this.file=t},fileAdded(t){this.avatar=t,this.avatarName=t.name},submit(){if(this.submitted=!0,this.$v.$touch(),!this.$v.$invalid){this.errors=null;let t=new FormData;t.append("image",this.avatar,this.avatarName),_.each(this.formData,(o,m)=>{t.append(m,o)}),F.post("/api/products",t,{headers:{"Content-Type":"multipart/form-data"}}).then(o=>{this.showForm=!1,this.user=o.data.data}).catch(o=>{o.response.status===422&&(this.errors=[],_.each(o.response.data.errors,m=>{_.each(m,d=>{this.errors.push(d)})}))})}},productAdd(){if(this.submitted=!0,this.$v.$touch(),!this.$v.$invalid){let t=new FormData;t.append("name",this.product.name),t.append("manufacture_name",this.product.manufacture_name),t.append("manufacture_brand",this.product.manufacture_brand),t.append("price",this.product.price),t.append("image",this.file,this.image),F.post("http://localhost:8000/api/products",t).then(o=>o).catch(o=>o)}}}},O=e("p",{class:"card-title-desc"}," Fill all information below ",-1),j={key:0},G={class:"mb-3"},J=e("label",{for:"productname"},"Product Name",-1),Q={key:0,class:"invalid-feedback"},X={class:"mb-3"},Y=e("label",{for:"manufacturername"},"Manufacturer Name",-1),$={key:0,class:"invalid-feedback"},ee={class:"mb-3"},te=e("label",{for:"manufacturerbrand"},"Manufacturer Brand",-1),ae={key:0,class:"invalid-feedback"},oe={class:"mb-3"},re=e("label",{for:"price"},"Price",-1),ne={key:0,class:"invalid-feedback"},se={class:"mb-3"},le=e("label",{class:"control-label"},"Category",-1),ie={class:"mb-3"},de=e("label",{class:"control-label"},"Features",-1),ue=e("div",{class:"mb-3"},[e("label",{for:"productdesc"},"Product Description"),e("textarea",{id:"productdesc",class:"form-control",placeholder:"Product Description",rows:"5"})],-1),ce={class:"mt-2"},me={class:"file-info"},pe=e("p",{class:"card-title-desc"}," Fill all information below ",-1),fe=e("div",{class:"mb-3"},[e("label",{for:"metatitle"},"Meta title"),e("input",{id:"metatitle",name:"productname",type:"text",class:"form-control",placeholder:"Meta Title"})],-1),_e=e("div",{class:"mb-3"},[e("label",{for:"metakeywords"},"Meta Keywords"),e("input",{id:"metakeywords",name:"manufacturername",type:"text",class:"form-control",placeholder:"Meta Keywords"})],-1),he={class:"mb-3"},ve=e("label",{for:"metadescription"},"Meta Description",-1);function be(t,o,m,d,r,N){const V=l("PageHeader"),C=l("BCardTitle"),p=l("BCol"),w=l("multiselect"),g=l("BRow"),h=l("BButton"),D=l("BForm"),v=l("BCard"),q=l("DropZone"),k=l("BCardBody"),T=l("BFormTextarea"),x=l("Layout");return i(),I(x,null,{default:n(()=>[a(V,{title:"Add Product",pageTitle:"Ecommerce"}),a(g,null,{default:n(()=>[a(p,{cols:"12"},{default:n(()=>[a(v,null,{default:n(()=>[a(v,{"no-body":""},{default:n(()=>[a(C,null,{default:n(()=>[u("Basic Information")]),_:1}),O,r.errors?(i(),c("div",j,[(i(!0),c(L,null,H(r.errors,(s,A)=>(i(),c("div",{key:A,class:"alert alert-danger"},M(s),1))),128))])):f("",!0),a(D,{onSubmit:P(N.productAdd,["prevent"])},{default:n(()=>[a(g,null,{default:n(()=>[a(p,{sm:"6"},{default:n(()=>[e("div",G,[J,b(e("input",{id:"productname","onUpdate:modelValue":o[0]||(o[0]=s=>r.product.name=s),name:"name",type:"text",class:B(["form-control",{"is-invalid":r.submitted&&t.$v.product.name.$error}]),placeholder:"Product Name"},null,2),[[y,r.product.name]]),r.submitted&&!t.$v.product.name.required?(i(),c("div",Q," Product name is required. ")):f("",!0)]),e("div",X,[Y,b(e("input",{id:"manufacturername","onUpdate:modelValue":o[1]||(o[1]=s=>r.product.manufacture_name=s),name:"manufacture_name",type:"text",placeholder:"Manufacturer Name",class:B(["form-control",{"is-invalid":r.submitted&&t.$v.product.manufacture_name.$error}])},null,2),[[y,r.product.manufacture_name]]),r.submitted&&!t.$v.product.manufacture_name.required?(i(),c("div",$," Product manufacture_name is required. ")):f("",!0)]),e("div",ee,[te,b(e("input",{id:"manufacturerbrand","onUpdate:modelValue":o[2]||(o[2]=s=>r.product.manufacture_brand=s),name:"manufacture_brand",type:"text",class:B(["form-control",{"is-invalid":r.submitted&&t.$v.product.manufacture_brand.$error}]),placeholder:"Manufacturer Brand"},null,2),[[y,r.product.manufacture_brand]]),r.submitted&&!t.$v.product.manufacture_brand.required?(i(),c("div",ae," Product manufacture_brand is required. ")):f("",!0)]),e("div",oe,[re,b(e("input",{id:"price",name:"price","onUpdate:modelValue":o[3]||(o[3]=s=>r.product.price=s),placeholder:"Price",class:B([{"is-invalid":r.submitted&&t.$v.product.price.$error},"form-control"]),type:"text"},null,2),[[y,r.product.price]]),r.submitted&&!t.$v.product.price.required?(i(),c("div",ne," Product price is required. ")):f("",!0)])]),_:1}),a(p,{sm:"6"},{default:n(()=>[e("div",se,[le,a(w,{modelValue:r.value,"onUpdate:modelValue":o[4]||(o[4]=s=>r.value=s),options:r.options,class:"checkout-multiselect-form",placeholder:"Select"},null,8,["modelValue","options"])]),e("div",ie,[de,a(w,{modelValue:r.value1,"onUpdate:modelValue":o[5]||(o[5]=s=>r.value1=s),options:r.options,multiple:!0,class:"checkout-multiselect-form",placeholder:"Choose..."},null,8,["modelValue","options"])]),ue]),_:1})]),_:1}),e("div",ce,[a(h,{variant:"primary",class:"me-1"},{default:n(()=>[u(" Save Changes ")]),_:1}),a(h,{variant:"secondary"},{default:n(()=>[u("Cancel")]),_:1})])]),_:1},8,["onSubmit"])]),_:1})]),_:1}),a(v,{"no-body":""},{default:n(()=>[a(k,null,{default:n(()=>[a(C,{class:"mb-3"},{default:n(()=>[u("Product Images")]),_:1}),a(q,{onDrop:P(d.drop,["prevent"]),onChange:d.selectedFile},null,8,["onDrop","onChange"]),e("span",me,M(d.dropzoneFile.name),1)]),_:1})]),_:1}),a(v,{"no-body":""},{default:n(()=>[a(k,null,{default:n(()=>[a(C,null,{default:n(()=>[u("Meta Data")]),_:1}),pe,a(D,null,{default:n(()=>[a(g,null,{default:n(()=>[a(p,{sm:"6"},{default:n(()=>[fe,_e]),_:1}),a(p,{sm:"6"},{default:n(()=>[e("div",he,[ve,a(T,{id:"metadescription",class:"form-control",rows:"5",placeholder:"Meta Description"})])]),_:1})]),_:1}),a(h,{variant:"primary",class:"me-1"},{default:n(()=>[u(" Save Changes ")]),_:1}),a(h,{variant:"secondary"},{default:n(()=>[u("Cancel")]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})}const Ve=U(W,[["render",be]]);export{Ve as default};

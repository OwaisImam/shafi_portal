import{L as p}from"./main-29c7ebb4.js";import{P as f}from"./page-header-5e34e666.js";import{i as h}from"./img-1-9be92e7d.js";import{i as B,a as x}from"./img-6-dd6c3b71.js";import{i as y}from"./img-3-e430c75f.js";import{i as v}from"./img-4-67c86a9a.js";import{i as C}from"./img-5-ff3d94e5.js";import{i as w}from"./img-7-bffbd3dd.js";import{_ as b,r as c,c as L,w as l,o as k,a as e,d as i,b as s}from"../js/app2.js";import"./logo-light-deb27e23.js";import"./logo-9faa3827.js";import"./avatar-1-15b743f1.js";import"./avatar-3-36dc574b.js";const S={components:{Layout:p,PageHeader:f},data(){return{img1:h,img2:B,img3:y,img4:v,img5:C,img6:x,img7:w,slide:0,slide1:0,sliding:null}}},T=s("p",{class:"card-title-desc"},[i("Here’s a carousel with slides only. Note the presence of the "),s("code",null,".d-block"),i(" and "),s("code",null,".img-fluid"),i(" on carousel images to prevent browser default image alignment.")],-1),H=s("p",{class:"card-title-desc"},"Adding in the previous and next controls:",-1),N=s("p",{class:"card-title-desc"},"You can also add the indicators to the carousel, alongside the controls, too.",-1),P=s("p",{class:"card-title-desc"},[i("Add captions to your slides easily with the "),s("code",null,".carousel-caption"),i(" element within any "),s("code",null,".carousel-item"),i(". ")],-1),A=s("div",{class:"carousel-caption d-none d-md-block text-white-50"},[s("h5",{class:"text-white"},"First slide label"),s("p",null,"Lorem ipsum dolor sit amet, consectetur adipiscing elit.")],-1),V=s("div",{class:"carousel-caption d-none d-md-block text-white-50"},[s("h5",{class:"text-white"},"Second slide label"),s("p",null,"Lorem ipsum dolor sit amet, consectetur adipiscing elit.")],-1),W=s("div",{class:"carousel-caption d-none d-md-block text-white-50"},[s("h5",{class:"text-white"},"Third slide label"),s("p",null,"Lorem ipsum dolor sit amet, consectetur adipiscing elit.")],-1),E=s("p",{class:"card-title-desc"},[i("Add "),s("code",null,".carousel-fade"),i(" to your carousel to animate slides with a fade transition instead of a slide.")],-1);function R(F,I,O,U,o,Y){const _=c("PageHeader"),r=c("BCardTitle"),t=c("BCarouselSlide"),a=c("BCarousel"),n=c("BCardBody"),d=c("BCard"),u=c("BCol"),m=c("BRow"),g=c("Layout");return k(),L(g,null,{default:l(()=>[e(_,{title:"Carousel",pageTitle:"UI Elements"}),e(m,null,{default:l(()=>[e(u,{xl:"6"},{default:l(()=>[e(d,{"no-body":""},{default:l(()=>[e(n,null,{default:l(()=>[e(r,null,{default:l(()=>[i("Slides only")]),_:1}),T,e(a,{interval:3e3,ride:"carousel",class:"carousel slide",id:"carouselExampleSlidesOnly"},{default:l(()=>[e(t,{active:"","img-src":o.img1},null,8,["img-src"]),e(t,{"img-src":o.img2},null,8,["img-src"]),e(t,{"img-src":o.img3},null,8,["img-src"])]),_:1})]),_:1})]),_:1})]),_:1}),e(u,{xl:"6"},{default:l(()=>[e(d,{"no-body":""},{default:l(()=>[e(n,null,{default:l(()=>[e(r,null,{default:l(()=>[i("With controls")]),_:1}),H,e(a,{class:"carousel slide",ride:"carousel",interval:2e3,controls:""},{default:l(()=>[e(t,{active:"","img-src":o.img4},null,8,["img-src"]),e(t,{"img-src":o.img5},null,8,["img-src"]),e(t,{"img-src":o.img6},null,8,["img-src"])]),_:1})]),_:1})]),_:1})]),_:1})]),_:1}),e(m,null,{default:l(()=>[e(u,{xl:"6"},{default:l(()=>[e(d,{"no-body":""},{default:l(()=>[e(n,null,{default:l(()=>[e(r,null,{default:l(()=>[i("With indicators")]),_:1}),N,e(a,{class:"carousel slide",ride:"carousel",interval:2e3,controls:"",indicators:""},{default:l(()=>[e(t,{active:"","img-src":o.img3},null,8,["img-src"]),e(t,{"img-src":o.img2},null,8,["img-src"]),e(t,{"img-src":o.img1},null,8,["img-src"])]),_:1})]),_:1})]),_:1})]),_:1}),e(u,{xl:"6"},{default:l(()=>[e(d,{"no-body":""},{default:l(()=>[e(n,null,{default:l(()=>[e(r,null,{default:l(()=>[i("With captions")]),_:1}),P,e(a,{class:"carousel slide",ride:"carousel",interval:2e3,controls:""},{default:l(()=>[e(t,{active:"","img-src":o.img7},{default:l(()=>[A]),_:1},8,["img-src"]),e(t,{"img-src":o.img5},{default:l(()=>[V]),_:1},8,["img-src"]),e(t,{"img-src":o.img4},{default:l(()=>[W]),_:1},8,["img-src"])]),_:1})]),_:1})]),_:1})]),_:1})]),_:1}),e(m,null,{default:l(()=>[e(u,{xl:"6"},{default:l(()=>[e(d,{"no-body":""},{default:l(()=>[e(n,null,{default:l(()=>[e(r,null,{default:l(()=>[i("Crossfade")]),_:1}),E,e(a,{class:"carousel slide carousel-fade",ride:"carousel",interval:2e3,controls:"",indicators:""},{default:l(()=>[e(t,{active:"","img-src":o.img1},null,8,["img-src"]),e(t,{"img-src":o.img2},null,8,["img-src"]),e(t,{"img-src":o.img3},null,8,["img-src"])]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})}const le=b(S,[["render",R]]);export{le as default};

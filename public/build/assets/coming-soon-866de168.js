import{a as l,l as d}from"./logo-light-deb27e23.js";import{_ as r,c as h,a as s,g as i,t as n,o as _}from"../js/app2.js";const m="/build/icons/coming-soon.svg",u={data(){return{start:"",end:"",interval:"",days:"",minutes:"",hours:"",seconds:"",starttime:"Mar 23, 2023 15:37:25",endtime:"Dec 31, 2025 16:37:25",logoDark:l,logoLight:d,coming:m}},created(){window.addEventListener("scroll",this.windowScroll)},destroyed(){window.removeEventListener("scroll",this.windowScroll)},mounted(){this.start=new Date(this.starttime).getTime(),this.end=new Date(this.endtime).getTime(),this.timerCount(this.start,this.end),this.interval=setInterval(()=>{this.timerCount(this.start,this.end)},1e3)},methods:{timerCount:function(o,a){var c=new Date().getTime(),e=o-c,t=a-c;if(e<0&&t<0){clearInterval(this.interval);return}else e<0&&t>0?this.calcTime(t):e>0&&t>0&&this.calcTime(e)},calcTime:function(o){this.days=Math.floor(o/(1e3*60*60*24)),this.hours=Math.floor(o%(1e3*60*60*24)/(1e3*60*60)),this.minutes=Math.floor(o%(1e3*60*60)/(1e3*60)),this.seconds=Math.floor(o%(1e3*60)/1e3)}},page:{title:"coming-soon",meta:[{name:"description"}]}},g=s("div",{class:"home-btn d-none d-sm-block"},[s("a",{href:"/",class:"text-dark"},[s("i",{class:"fas fa-home h2"})])],-1),v={class:"my-5 pt-sm-5"},f={class:"container"},p={class:"row"},w={class:"col-lg-12"},x={class:"text-center"},b={href:"/",class:"d-block auth-logo"},k=["src"],y=["src"],D={class:"row justify-content-center mt-5"},T={class:"col-sm-4"},M={class:"maintenance-img"},S=["src"],L=s("h4",{class:"mt-5"},"Let's get started with Skote",-1),B=s("p",{class:"text-muted"}," It will be as simple as Occidental in fact it will be Occidental. ",-1),C={class:"row justify-content-center mt-5"},E={class:"col-md-8"},I={"data-countdown":"2020/12/31",class:"counter-number ico-countdown"},j={class:"coming-box"},N=s("span",null,"Days",-1),O={class:"coming-box"},V=s("span",null,"Hours",-1),H={class:"coming-box"},q=s("span",null,"Minutes",-1),z={class:"coming-box"},A=s("span",null,"Seconds",-1);function F(o,a,c,e,t,G){return _(),h("div",null,[g,s("section",v,[s("div",f,[s("div",p,[s("div",w,[s("div",x,[s("a",b,[s("img",{src:t.logoDark,alt:"",height:"20",class:"auth-logo-dark mx-auto"},null,8,k),s("img",{src:t.logoLight,alt:"",height:"20",class:"auth-logo-light mx-auto"},null,8,y)]),s("div",D,[s("div",T,[s("div",M,[s("img",{src:t.coming,alt:"",class:"img-fluid mx-auto d-block"},null,8,S)])])]),L,B,s("div",C,[s("div",E,[s("div",I,[s("div",j,[i(n(t.days)+" ",1),N]),s("div",O,[i(n(t.hours)+" ",1),V]),s("div",H,[i(n(t.minutes)+" ",1),q]),s("div",z,[i(n(t.seconds)+" ",1),A])])])])])])])])])])}const P=r(u,[["render",F]]);export{P as default};

import{c as h,a as _,b as d,e as v,F as n,E as c,d as g}from"./chunk-index.esm.js";import{r as y,l as $,b as u,c as p,d as s,e,w as C,f as o,n as V,m as N}from"./app-app2.js";const k={class:"card-body"},q={class:"form-group"},E=s("label",{for:"current-password"},"Current Password",-1),U={class:"mb-3 text-danger"},B={class:"form-group"},F=s("label",{for:"new-password"},"New Password",-1),M={class:"mb-3 text-danger"},O={class:"form-group"},S=s("label",{for:"confirm-password"},"Confirm Password",-1),x={class:"mb-3 text-danger"},R=["disabled"],T={name:"PasswordTab",props:["active","id"],setup(l){const i=l;h({validateOnInput:!0});const w=_({currentPassword:d().required("Current Password Required").min(8,"Minimum of 8 Characters"),newPassword:d().required("New Password Required").min(8,"Minimum of 8 Characters"),confirmPassword:d().oneOf([v("newPassword"),null],"Password must match to New Password")}),f=y({currentPassword:"",newPassword:"",confirmPassword:""}),m=$();async function b(){try{const{data:a}=N.post("/api/change-password",f);console.log(a),m.success("Successfuly Changed")}catch{m.error("Database Error")}}return(a,r)=>(u(),p("div",{class:V(`tab-pane fade ${i.active?"active show":""}`),id:"password",role:"tabpanel","aria-labelledby":"password-tab"},[s("div",k,[e(o(g),{"validation-schema":o(w),onSubmit:b},{default:C(({errors:P})=>[s("div",q,[E,e(o(n),{modelValue:a.currentPassword,"onUpdate:modelValue":r[0]||(r[0]=t=>a.currentPassword=t),name:"currentPassword",type:"password",class:"form-control",id:"current-password",placeholder:"Current Password"},null,8,["modelValue"]),s("div",U,[e(o(c),{name:"currentPassword"})])]),s("div",B,[F,e(o(n),{modelValue:a.newPassword,"onUpdate:modelValue":r[1]||(r[1]=t=>a.newPassword=t),name:"newPassword",type:"password",class:"form-control",id:"new-password",placeholder:"New Password"},null,8,["modelValue"]),s("div",M,[e(o(c),{name:"newPassword"})])]),s("div",O,[S,e(o(n),{modelValue:a.confirmPassword,"onUpdate:modelValue":r[2]||(r[2]=t=>a.confirmPassword=t),name:"confirmPassword",type:"password",class:"form-control",id:"confirm-password",placeholder:"Confirm Password"},null,8,["modelValue"]),s("div",x,[e(o(c),{name:"confirmPassword"})])]),s("button",{class:"btn btn-info float-right",disabled:Object.keys(P).length!=0}," Change ",8,R)]),_:1},8,["validation-schema"])])],2))}},j={class:"row"},z={class:"col-12"},D={class:"card card-primary card-outline card-outline-tabs"},I=s("div",{class:"card-header p-0 border-bottom-0"},[s("ul",{class:"nav nav-tabs",id:"custom-tabs-four-tab",role:"tablist"},[s("li",{class:"nav-item"},[s("a",{class:"nav-link active",id:"password-tab","data-toggle":"pill",href:"#password",role:"tab","aria-controls":"password","aria-selected":"true"},"Password")])])],-1),A={class:"card-body"},J={name:"SecurityPage",setup(l){return(i,w)=>(u(),p("div",j,[s("div",z,[s("div",D,[I,s("div",A,[e(T,{active:!0})])])])]))}};export{J as default};

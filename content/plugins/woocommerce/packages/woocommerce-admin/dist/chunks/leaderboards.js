(window.__wcAdmin_webpackJsonp=window.__wcAdmin_webpackJsonp||[]).push([[34],{496:function(e,t,r){"use strict";var a=r(11),n=r.n(a),o=r(12),c=r.n(o),s=r(13),i=r.n(s),l=r(14),d=r.n(l),u=r(6),m=r.n(u),b=r(0),f=r(2),p=r(1),h=r.n(p),y=r(47),g=r(25);function _(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}();return function(){var r,a=m()(e);if(t){var n=m()(this).constructor;r=Reflect.construct(a,arguments,n)}else r=a.apply(this,arguments);return d()(this,r)}}var w=function(e){i()(r,e);var t=_(r);function r(){return n()(this,r),t.apply(this,arguments)}return c()(r,[{key:"render",value:function(){var e,t,r,a,n=this.props,o=n.className,c=n.isError,s=n.isEmpty;return c?(e=Object(f.__)("There was an error getting your stats. Please try again.",'woocommerce'),t=Object(f.__)("Reload",'woocommerce'),a=function(){window.location.reload()}):s&&(e=Object(f.__)("No results could be found for this date range.",'woocommerce'),t=Object(f.__)("View Orders",'woocommerce'),r=Object(g.f)("edit.php?post_type=shop_order")),Object(b.createElement)(y.EmptyContent,{className:o,title:e,actionLabel:t,actionURL:r,actionCallback:a})}}]),r}(b.Component);w.propTypes={className:h.a.string,isError:h.a.bool,isEmpty:h.a.bool},w.defaultProps={className:""},t.a=w},505:function(e,t,r){"use strict";var a=r(510),n=["a","b","em","i","strong","p","br"],o=["target","href","rel","name","download"];t.a=function(e){return{__html:Object(a.sanitize)(e,{ALLOWED_TAGS:n,ALLOWED_ATTR:o})}}},573:function(e,t,r){},574:function(e,t,r){},599:function(e,t,r){"use strict";r.r(t);var a=r(19),n=r.n(a),o=r(34),c=r.n(o),s=r(0),i=r(2),l=r(18),d=r(1),u=r.n(d),m=r(4),b=r(15),f=r(47),p=r(23),h=r(25),y=r(28),g=r(11),_=r.n(g),w=r(12),O=r.n(w),j=r(13),v=r.n(j),E=r(14),R=r.n(E),T=r(6),k=r.n(T),L=r(21),q=r(31),S=r(496),C=r(505);r(573);function N(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}();return function(){var r,a=k()(e);if(t){var n=k()(this).constructor;r=Reflect.construct(a,arguments,n)}else r=a.apply(this,arguments);return R()(this,r)}}var I=function(e){v()(r,e);var t=N(r);function r(){return _()(this,r),t.apply(this,arguments)}return O()(r,[{key:"getFormattedHeaders",value:function(){return this.props.headers.map((function(e,t){return{isLeftAligned:0===t,hiddenByDefault:!1,isSortable:!1,key:e.label,label:e.label}}))}},{key:"getFormattedRows",value:function(){return this.props.rows.map((function(e){return e.map((function(e){return{display:Object(s.createElement)("div",{dangerouslySetInnerHTML:Object(C.a)(e.display)}),value:e.value}}))}))}},{key:"render",value:function(){var e=this.props,t=e.isRequesting,r=e.isError,a=e.totalRows,n=e.title,o="woocommerce-leaderboard";if(r)return Object(s.createElement)(S.a,{className:o,isError:!0});var c=this.getFormattedRows();return t||0!==c.length?Object(s.createElement)(f.TableCard,{className:o,headers:this.getFormattedHeaders(),isLoading:t,rows:c,rowsPerPage:a,showMenu:!1,title:n,totalRows:a}):Object(s.createElement)(m.Card,{className:o},Object(s.createElement)(m.CardHeader,null,Object(s.createElement)(q.f,{variant:"title.small",as:"h3"},n)),Object(s.createElement)(m.CardBody,{size:null},Object(s.createElement)(f.EmptyTable,null,Object(i.__)("No data recorded for the selected time period.",'woocommerce'))))}}]),r}(s.Component);I.propTypes={headers:u.a.arrayOf(u.a.shape({label:u.a.string})),id:u.a.string.isRequired,query:u.a.object,rows:u.a.arrayOf(u.a.arrayOf(u.a.shape({display:u.a.node,value:u.a.oneOfType([u.a.string,u.a.number,u.a.bool])}))).isRequired,title:u.a.string.isRequired,totalRows:u.a.number.isRequired},I.defaultProps={rows:[],isError:!1,isRequesting:!1};var P=Object(l.compose)(Object(b.withSelect)((function(e,t){var r=t.id,a=t.query,n=t.totalRows,o=t.filters,c=e(p.SETTINGS_STORE_NAME).getSetting("wc_admin","wcAdminSettings").woocommerce_default_date_range,s=Object(p.getFilterQuery)({filters:o,query:a}),i={id:r,per_page:n,persisted_query:Object(L.getPersistedQuery)(a),query:a,select:e,defaultDateRange:c,filterQuery:s};return Object(p.getLeaderboard)(i)})))(I),A=(r(574),function(e){var t=e.allLeaderboards,r=e.controls,a=e.isFirst,o=e.isLast,l=e.hiddenBlocks,d=e.onMove,u=e.onRemove,b=e.onTitleBlur,h=e.onTitleChange,g=e.onToggleHiddenBlock,_=e.query,w=e.title,O=e.titleInput,j=e.filters,v=Object(p.useUserPreferences)(),E=v.updateUserPreferences,R=c()(v,["updateUserPreferences"]),T=Object(s.useState)(parseInt(R.dashboard_leaderboard_rows||5,10)),k=n()(T,2),L=k[0],q=k[1],S=function(e){q(parseInt(e,10));var t={dashboard_leaderboard_rows:parseInt(e,10)};E(t)};return Object(s.createElement)(s.Fragment,null,Object(s.createElement)("div",{className:"woocommerce-dashboard__dashboard-leaderboards"},Object(s.createElement)(f.SectionHeader,{title:w||Object(i.__)("Leaderboards",'woocommerce'),menu:Object(s.createElement)(f.EllipsisMenu,{label:Object(i.__)("Choose which leaderboards to display and other settings",'woocommerce'),renderContent:function(e){var n=e.onToggle;return Object(s.createElement)(s.Fragment,null,Object(s.createElement)(f.MenuTitle,null,Object(i.__)("Leaderboards",'woocommerce')),function(e){var t=e.allLeaderboards,r=e.hiddenBlocks,a=e.onToggleHiddenBlock;return t.map((function(e){var t=!r.includes(e.id);return Object(s.createElement)(f.MenuItem,{checked:t,isCheckbox:!0,isClickable:!0,key:e.id,onInvoke:function(){a(e.id)(),Object(y.recordEvent)("dash_leaderboards_toggle",{status:t?"off":"on",key:e.id})}},e.label)}))}({allLeaderboards:t,hiddenBlocks:l,onToggleHiddenBlock:g}),Object(s.createElement)(m.SelectControl,{className:"woocommerce-dashboard__dashboard-leaderboards__select",label:Object(i.__)("Rows Per Table",'woocommerce'),value:L,options:Array.from({length:20},(function(e,t){return{v:t+1,label:t+1}})),onChange:S}),window.wcAdminFeatures["analytics-dashboard/customizable"]&&Object(s.createElement)(r,{onToggle:n,onMove:d,onRemove:u,isFirst:a,isLast:o,onTitleBlur:b,onTitleChange:h,titleInput:O}))}})}),Object(s.createElement)("div",{className:"woocommerce-dashboard__columns"},function(e){var t=e.allLeaderboards,r=e.hiddenBlocks,a=e.query,n=e.rowsPerTable,o=e.filters;return t.map((function(e){if(!r.includes(e.id))return Object(s.createElement)(P,{headers:e.headers,id:e.id,key:e.id,query:a,title:e.label,totalRows:n,filters:o})}))}({allLeaderboards:t,hiddenBlocks:l,query:_,rowsPerTable:L,filters:j}))))});A.propTypes={query:u.a.object.isRequired};t.default=Object(l.compose)(Object(b.withSelect)((function(e){var t=e(p.ITEMS_STORE_NAME),r=t.getItems,a=t.getItemsError;return{allLeaderboards:Object(h.g)("dataEndpoints",{leaderboards:[]}).leaderboards,getItems:r,getItemsError:a}})))(A)}}]);
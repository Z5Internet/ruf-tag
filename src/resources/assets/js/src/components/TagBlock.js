"use strict";function _interopRequireDefault(e){return e&&e.__esModule?e:{default:e}}function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function _possibleConstructorReturn(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}function _inherits(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}var _createClass=function(){function e(e,t){for(var a=0;a<t.length;a++){var r=t[a];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}return function(t,a,r){return a&&e(t.prototype,a),r&&e(t,r),t}}(),_react=require("react"),_react2=_interopRequireDefault(_react),_DMReactComponent2=require("rufUtils/DMReactComponent"),_DMReactComponent3=_interopRequireDefault(_DMReactComponent2),_redexConnect=require("rufUtils/redex-connect"),_redexConnect2=_interopRequireDefault(_redexConnect),_BatchsGraph=require("../Graph/BatchsGraph"),_TagsGraph=require("../Graph/TagsGraph"),TagBlock=function(e){function t(e,a){return _classCallCheck(this,t),_possibleConstructorReturn(this,(t.__proto__||Object.getPrototypeOf(t)).call(this,e,a))}return _inherits(t,e),_createClass(t,[{key:"componentDidMount",value:function(){(0,_BatchsGraph.getBatchs)(this.props.type,this.props.id)}},{key:"changeTag",value:function(e){var t="batch_"+e.id,a=this.refs[t].value,r=this.props.tagBatchs[e.id];r.tags||(r.tags=[{name:""}]),r.tags[0].name=a,this.store.dispatch({type:"Add_tag_batchs",batchs:r}),(0,_TagsGraph.addTag)({tag:a,id:this.props.id,bid:e.id,taggable_type:e.taggable_type})}},{key:"render",value:function(){var e=(this.props.id,this.props.type),t=this;return _react2.default.createElement("div",null,this.props.tagBatchs.map(function(a){if(a.taggable_type==e&&1==a.options.quantity){var r="";return a.tags&&a.tags[0]&&(r=a.tags[0].name),_react2.default.createElement("div",{key:a.id},_react2.default.createElement("h3",null,a.name),_react2.default.createElement("select",{className:"form-control",ref:"batch_"+a.id,value:r,onChange:t.changeTag.bind(t,a)},!r&&_react2.default.createElement("option",null),a.options.selections.map(function(e,t){return _react2.default.createElement("option",{key:t,value:e.name},e.name)})))}}))}}]),t}(_DMReactComponent3.default);module.exports=(0,_redexConnect2.default)(TagBlock,{tagBatchs:"tagBatchs",tagBatchNames:"tagBatchNames"});
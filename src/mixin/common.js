module.exports = {
  install(Vue, router) {    
    const on = (selector, event, handler, element=document) => {
      element.addEventListener(event, (e) => { if(e.target.matches(selector)) handler(e); });
    };
    const get_query = (url) => {
      var qs = url.substring(url.indexOf('?') + 1).split('&');
      for(var i = 0, result = {}; i < qs.length; i++){
          qs[i] = qs[i].split('=');
          result[qs[i][0]] = decodeURIComponent(qs[i][1]);
      }
      return result;
    };
    Vue.sv_member = function () {
      on('[data-href]','click',  e => {
        e.preventDefault();
        e.stopPropagation();
        const type = e.target.dataset.type ? e.target.dataset.type.trim() : '';
        const href = e.target.dataset.href;
        if(type == "win_memo") {
          router.push({name : 'memo', query : get_query(href)});
        } else if(type == "win_email") {
          alert('아직 지원되지 않는 기능입니다')
        } else if(type == "win_profile") {
          alert('아직 지원되지 않는 기능입니다')
        } else if(type == "win_email") {
          alert('아직 지원되지 않는 기능입니다')
        }else{
          var query = get_query(href);
          if(query.sfl && query.stx && href.indexOf('point_list.php') != -1 ) { //아이디로 검색
            router.push({name : 'point', query : get_query(href)});
          }else if(query.mb_id && href.indexOf('new.php') != -1) { //포인트내역
            router.push({name : 'New', query : get_query(href)});
          }else if(e.target.innerText == '아이디로 검색' ){
            router.push({name : 'list', params : {bo_table : router.history.current.params.bo_table}, query : get_query(href)});
          }
        }
      })
    }
    Vue.sv_member();
  }
}
<template>
  <div class="my-4 dark:bg-gray-700 dark:text-gray-400">
    <t-alert variant="danger" show v-if="list.msg" :dismissible="false">
      {{list.msg}}
    </t-alert>
    <header v-if="list.board_head" v-html="list.board_head"> </header>
    <header class="py-3 px-3 flex" v-if="list">
      <div v-for="row in list.category" :key="row.name">
        <h2 class="px-1">
          <router-link :to="{ name : 'list', params : {bo_table : $route.params.bo_table} , query : {sca : (row.name == '전체' ? '' : row.name) }}" class="bo_v_cate bg-gray-800 p-2 rounded text-gray-100 cursor-pointer">{{row.name}}</router-link> 
          <span class="bo_v_tit"> </span>
        </h2>
      </div>
    </header>
    <t-modal name="sw_modal">
      <template v-slot:header>
        <div> {{ao.sw == 'copy' ? '게시물 복사' : '게시물 이동'}} </div>
      </template>
      <form name="fboardmoveall" ref="fboardmoveall" method="post" @submit.prevent="move_update">
        <input type="hidden" name="sw" :value="ao.sw">
        <input type="hidden" name="bo_table" :value="ao.bo_table">
        <input type="hidden" name="wr_id_list" :value="ao.wr_id_list">
        <input type="hidden" name="sfl" :value="ao.sfl">
        <input type="hidden" name="stx" :value="ao.stx">
        <input type="hidden" name="spt" :value="ao.spt">
        <input type="hidden" name="sst" :value="ao.sst">
        <input type="hidden" name="sod" :value="ao.sod">
        <input type="hidden" name="page" :value="ao.page">
        <input type="hidden" name="act" :value="ao.act">
        <input type="hidden" name="url" :value="ao.HTTP_REFERER">
        <div class="border-b text-center text-xl font-bold py-2">  게시판 </div>
        <div class="flex py-3 border-b justify-between px-3 items-center" v-for="(row, i) in ao.list" :key="i" v-bind:class="{'bg-gray-100' : row.bo_table == $route.params.bo_table}"> <!-- $route.params.bo_table -->
          <div class="items-center flex">
            <div class="inline-flex items-center justify-center mr-4">
              <input type="checkbox" name="chk_bo_table[]" :value="row.bo_table" class="form-checkbox h-5 w-5 text-blue-600">
                <b class="sound_only">현재 페이지 게시물  전체선택</b>
            </div>
            {{row.gr_subject}} > {{row.bo_subject}} ({{row.bo_table}}) 
          </div>
          <div>
            {{row.bo_table == $route.params.bo_table ? '현재' : ''}}
          </div>
        </div>
      </form>
      <template v-slot:footer>
        <div class="flex justify-around">
          <t-button variant="primary" type="submit" class="w-1/4" @click="move_update"> 복사 </t-button>
          <t-button  class="w-1/4" type="button" @click="$modal.hide('sw_modal')"> 창 닫기 </t-button>
        </div>
      </template>
    </t-modal>
    <form name="fboardlist" id="fboardlist" ref="fboardlist" @submit.prevent="onSubmit" method="post">
      <input type="hidden" name="bo_table" :value="$route.params.bo_table">
      <input type="hidden" name="sfl" :value="list.sfl">
      <input type="hidden" name="stx" :value="list.stx">
      <input type="hidden" name="spt" :value="list.spt">
      <input type="hidden" name="sca" :value="list.sca">
      <input type="hidden" name="sst" :value="list.sst">
      <input type="hidden" name="sod" :value="list.sod">
      <input type="hidden" name="page" :value="list.page">
      <input type="hidden" name="sw" >
      <div id="bo_btn_top" v-if="list">
        <div id="bo_list_total" class="flex m-3 justify-end md:text-sm text-xs">
            <div class="border-gray-800 bg-gray-300 p-2 rounded dark:bg-gray-600 dark:text-gray-300">
            <span>Total {{list.total_count}}건 </span>
            {{list.page}} 페이지
            </div>
        </div>
      </div>
      <ul class="flex mx-3 my-3 justify-end">
          <li v-if="list.admin_href" class=""><a class='hover:bg-red-700 bg-red-500 text-white py-2 px-2 mx-1 rounded text-sm block' :href="list.admin_href" data-balloon-pos="down-right" aria-label="관리자"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">관리자</span></a></li>
          <li v-if="list.rss_href" class=""><a class="hover:bg-indigo-700 bg-indigo-500 text-white py-2 px-2 mx-1 rounded text-sm block" :href="list.rss_href" data-balloon-pos="down-right" aria-label="RSS"><i class="fas fa-rss"></i><span class="sound_only">RSS</span></a></li>
          <li>
            <button type="button" class="hover:bg-purple-700 bg-purple-500 text-white py-2 px-2 mx-1 rounded text-sm board-search"  @click="$modal.show('Search-Modal')" data-balloon-pos="down-right" aria-label="게시판 검색"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">게시판 검색</span></button>
          </li>
          <li v-if="list.write_href"><router-link :to="list.write_href" class="block hover:bg-teal-700 bg-teal-500 text-white py-2 px-2 mx-1 rounded text-sm" data-balloon-pos="down-right" aria-label="글쓰기"><i class="fas fa-pencil-alt"></i><span class="sound_only">글쓰기</span></router-link></li>    	
        <li v-if="list.is_checkbox">
          <ul v-if="list.is_checkbox == true" class="more_opt flex justify-start">  
              <li> <button class="board-opt border dark:border-gray-400 hover:bg-red-700 bg-red-500 text-white py-2 px-3 mx-1 rounded text-sm" type="button" name="btn_submit" value="선택삭제" v-on:click='fboardlist("선택삭제")'><i class="fas fa-trash-alt"></i> <span class="md:inline-block hidden"> 선택삭제 </span> </button></li>
              <li> <button class="board-opt border dark:border-gray-400 hover:bg-green-700 bg-green-500 text-white py-2 px-3 mx-1 rounded text-sm" type="button" name="btn_submit" value="선택복사" v-on:click='fboardlist("선택복사")'><i class="fas fa-file-alt"></i> <span class="md:inline-block hidden"> 선택복사 </span> </button></li>
              <li> <button class="board-opt border dark:border-gray-400 hover:bg-indigo-700 bg-indigo-500 text-white py-2 px-3 mx-1 rounded text-sm" type="button" name="btn_submit" value="선택이동" v-on:click='fboardlist("선택이동")'><i class="fas fa-arrows-alt"></i> <span class="md:inline-block hidden"> 선택이동 </span> </button></li>
          </ul>
        </li>
      </ul>
      <t-modal header="검색" name="Search-Modal">
        <t-select class="w-full p-2 border my-2 rounded" id="sfl"
        :options="[
            { label: '제목', value : 'wr_subject'},
            { label: '내용', value : 'wr_content'},
            { label: '제목+내용', value : 'wr_subject||wr_content'},
            { label: '회원아이디', value : 'mb_id,1'},
            { label: '회원아이디(코)', value : 'mb_id,0'},
            { label: '글쓴이', value : 'wr_name,1'},
            { label: '글쓴이(코)', value : 'wr_name,0'},
          ]"
        ></t-select>
        <div class="flex relative">
        <t-input class="my-1" value="" placeholder="검색어를 입력해주세요" id="stx" @keyup.enter="search" /> 
        <button class="absolute right-0 top-0 py-2 px-3 border-l my-1"> <i class="fa fa-search" @keyup.enter="search" @click="search"> </i> </button>
        </div>
      </t-modal>
      <div class="my-4 rounded select-none" v-if="list && list.board.bo_skin.indexOf('gallery') == -1">
        <div v-for="(row, i) in list.list" :key="row.wr_id" class="border-t border-r border-l -my-px mx-3 bg-white block md:grid gap-0 v-list dark:bg-gray-900 dark:border-gray-600 dark:text-gray-400" v-bind:class="[grid]" :style="{gridTemplateColumns : colwidth}">
          <div v-if="list.is_checkbox == true && i==0" class="hidden md:inline-flex items-center dark:border-gray-600 border-b border-r justify-center">
            <input type="checkbox" id="chkall" class="form-checkbox h-5 w-5 text-blue-600"  ref="chkall" @click="chkall">
              <b class="sound_only">현재 페이지 게시물  전체선택</b>
          </div>
          <div v-if="i==0" class="hidden md:block py-2 dark:border-gray-600 border-r border-b whitespace-no-wrap text-center">번호</div>
          <div v-if="i==0" class="hidden md:block py-2 dark:border-gray-600 border-r border-b pl-2">제목</div>
          <div v-if="i==0" class="hidden md:block py-2 dark:border-gray-600 border-r border-b pl-2 text-center">글쓴이</div>
          <div v-if="i==0" class="hidden md:block py-2 dark:border-gray-600 border-r border-b text-center"> 
            <router-link :to="list.sort_wr_hit"> 조회 <span v-html="wr_hit_order"></span> </router-link>
          </div>
          <div v-if="list.is_good && i==0" class="hidden md:block py-2 dark:border-gray-600 border-r border-b text-center"> 
            <router-link :to="list.sort_wr_good"> 추천 <span v-html="wr_good_order"></span> </router-link>
          </div>
          <div v-if="list.is_nogood && i==0" class="hidden md:block py-2 dark:border-gray-600 border-r border-b text-center"> 
            <router-link :to="list.sort_wr_nogood"> 비추천 <span v-html="wr_nogood_order"></span> </router-link>
          </div>
          <div v-if="i==0" class="hidden md:block py-2 border-b text-center dark:border-gray-600">
            <router-link :to="list.sort_wr_datetime">날짜  <span v-html="wr_datetime_order"></span> </router-link>
          </div>
          <div v-if="list.is_checkbox == true" class="dark:border-gray-600 float-right absolute md:relative md:float-none md:inline-flex items-center md:py-0 py-1 md:px-0 px-1 md:border-b md:border-r justify-center py-2 md:py-0" v-bind:class="{'bg-blue-100 dark:bg-blue-900' : row.is_notice}">
              <input type="checkbox" name="chk_wr_id[]" :value="row.wr_id" :id="'chk_wr_id_'+i" class="selec_chk form-checkbox h-5 w-5 text-blue-600 mt-1 md:mt-0">
              <b class="sound_only">현재 페이지 게시물  전체선택</b>
          </div>
          <div class="hidden md:block md:float-none text-center md:h-auto py-2 dark:border-gray-600 md:border-r md:border-b text-gray-700 text-sm dark:text-gray-400" v-bind:class="{'bg-blue-100 dark:bg-blue-900' : row.is_notice}"> {{row.num}} <span v-if="row.is_notice"> {{row.ca_name}} </span> </div>
          <router-link :to="row.href" class="float-left md:float-none md:inline-block hover:bg-gray-200 dark:hover:bg-gray-700 py-2 pl-2 dark:border-gray-600 md:border-r md:border-b whitespace-no-wrap truncate w-full" v-bind:class="{'bg-blue-100 dark:bg-blue-900' : row.is_notice, 'pl-8 md:pl-2' : list.is_checkbox}">
            <span v-if="row.ca_name" class="bo_v_cate bg-gray-800 inline-block p-1 dark:border-gray-600 dark:bg-gray-600 text-xs justify-center rounded text-gray-100"> {{row.ca_name}} </span>
            {{row.wr_subject}} 
            <span v-if="row.icon_new" class="bg-green-400 px-2 py-1 rounded text-white text-xs">N</span>
            <i v-if="row.icon_hot" class="ml-1 text-red-700 fab fa-hotjar"></i>
            <i v-if="row.icon_file" class="ml-1 text-gray-700 dark:text-gray-400 fas fa-download"></i>
            <i v-if="row.icon_link" class="ml-1 text-gray-700 dark:text-gray-400 fas fa-link"></i>
            <i v-if="row.icon_secret" class="ml-1 text-gray-700 dark:text-gray-400 fas fa-lock"></i>
            <span v-if="row.comment_cnt" class="mx-1"> <span class="sound_only">댓글</span><span class="bg-blue-500 text-white text-xs py-1 px-2 rounded">{{row.wr_comment}}</span><span class="sound_only">개</span></span>
          </router-link>
          <div class="md:flex md:items-center clear-both float-left whitespace-no-wrap truncate md:border-b py-1 pl-2 md:border-r text-gray-600 md:mr-0 mr-2 md:text-gray-700 text-sm md:mr-0 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-400" ref="nickname" v-bind:class="{'bg-blue-100 dark:bg-blue-900' : row.is_notice}" :inner-html.prop="row.name|mb_nick" 
          @click="layer($refs.nickname, i)"> </div>
          <div class="dark:text-gray-400 md:flex md:items-center md:justify-end float-left md:float-none py-1 pr-2 dark:border-gray-600 md:border-r md:border-b text-right text-gray-600 md:mr-0 mr-2 md:text-gray-700 md:text-sm text-xs" v-bind:class="{'bg-blue-100 dark:bg-blue-900' : row.is_notice}"> <i class="md:hidden far fa-eye"></i> {{row.wr_hit}} </div>
          <div v-if="list.is_good" class="dark:text-gray-400 md:flex md:items-center md:justify-end float-left md:float-none py-1 pr-2 text-right dark:border-gray-600 md:border-r md:border-b text-gray-600 md:mr-0 mr-2 md:text-gray-700 md:text-sm text-xs" v-bind:class="{'bg-blue-100 dark:bg-blue-900' : row.is_notice}"> <i class="md:hidden far fa-thumbs-up"></i> {{row.wr_good}} </div>
          <div v-if="list.is_nogood" class="dark:text-gray-400 md:flex md:items-center md:justify-end float-left md:float-none py-1 pr-2 text-right dark:border-gray-600 md:border-r md:border-b text-gray-600 md:mr-0 mr-2 md:text-gray-700 md:text-sm text-xs" v-bind:class="{'bg-blue-100 dark:bg-blue-900' : row.is_notice}"> <i class="md:hidden far fa-thumbs-down"></i> {{row.wr_nogood}} </div>
          <div class="dark:text-gray-400 md:flex md:items-center md:justify-end md:float-none float-right py-1 pl-1 text-sm md:border-b text-right pr-2 whitespace-no-wrap text-gray-600 md:mr-0 md:text-gray-700 dark:border-gray-600 " v-bind:class="{'bg-blue-100 dark:bg-blue-900' : row.is_notice}"> {{row.datetime2}} </div>
          <div class="dark:text-gray-400 md:flex md:items-center md:justify-end md:hidden clearfix border-b border-t w-full -mt-px dark:border-gray-600 " v-bind:class="{'bg-blue-100 dark:bg-blue-900' : row.is_notice}"></div>
        </div>
        <div class="rounded mx-3 flex justify-center shadow p-3 bg-white dark:bg-gray-900 dark:text-gray-400 border dark:border-gray-500" v-if="typeof list.list != 'number' && list.list.length == 0"> 게시물이 없습니다.</div>
      </div>
      <Gallery v-else-if="list" 
      v-bind:list="list.list" 
      v-bind:g="list"
      class="my-4 rounded select-none">
      </Gallery>
        <t-pagination v-if="$route.query.page"
          :total-items="list.total_page"
          :per-page="list.perpage"
          :limit="list.limit"
          :disabled="false"
          :v-model="parseInt($route.query.page)"
          @change="pageMove"
        />
      <div class="bo_fx" v-if="list.write_href || list.is_checkbox == true || list.list_href">
        <ul class="flex mx-3 my-3 justify-end">
          <li v-if="list.admin_href" class=""><a class='hover:bg-red-700 bg-red-500 text-white py-2 px-2 mx-1 rounded text-sm block' :href="list.admin_href" data-balloon-pos="up-right" aria-label="관리자"><i class="fa fa-cog fa-spin fa-fw"></i><span class="sound_only">관리자</span></a></li>
          <li v-if="list.rss_href" class=""><a class="hover:bg-indigo-700 bg-indigo-500 text-white py-2 px-2 mx-1 rounded text-sm block" :href="list.rss_href" data-balloon-pos="up-right" aria-label="RSS"><i class="fas fa-rss"></i><span class="sound_only">RSS</span></a></li>
          <li v-if="list.write_href" ><router-link :to="list.write_href" class="block hover:bg-teal-700 bg-teal-500 text-white py-2 px-2 mx-1 rounded text-sm" data-balloon-pos="up-right" aria-label="글쓰기"><i class="fas fa-pencil-alt"></i><span class="sound_only">글쓰기</span></router-link></li>
        </ul>	
      </div>
    </form>
    <footer v-if="list.board_tail" v-html="list.board_tail"> </footer>
  </div>
</template>

<script>
import gellery from './gallery'
export default {
  name: 'list',
  components : {
    'Gallery' : gellery,
  },
  data () {
    var colspan = 5;
    return {
      list : {
        board : {
          bo_skin : 'basic'
        },
        msg : null,
        list : 0,
      },
      colspan : colspan,
      col : ["2.5rem", "auto", "8rem", "4rem", "4rem"],
      grid : 'grid-cols-' + colspan,
      colwidth : null,
      stx : '',
      sfl : '',
      sca : '',
      ao : {
        list : null,
      }, //admin_order
      params : '',
      wr_nogood_order : this.$route.query.sst=='wr_nogood' && this.$route.query.sod == 'asc' ? '<i class="fas fa-sort-down"></i>' : this.$route.query.sst=='wr_nogood' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort"></i>',
      wr_good_order : this.$route.query.sst=='wr_good' && this.$route.query.sod == 'asc' ? '<i class="fas fa-sort-down"></i>' : this.$route.query.sst=='wr_good' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort"></i>',
      wr_hit_order : this.$route.query.sst=='wr_hit' && this.$route.query.sod == 'asc' ? '<i class="fas fa-sort-down"></i>' : this.$route.query.sst=='wr_hit' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort"></i>',
      wr_datetime_order : this.$route.query.sst=='wr_datetime' && this.$route.query.sod == 'asc' ? '<i class="fas fa-sort-down"></i>' : this.$route.query.sst=='wr_datetime' ? '<i class="fas fa-sort-up"></i>' : '<i class="fas fa-sort"></i>',
    }
  },
  methods : {    
    queryString () {
      var data = this.$route.query;
      var params = '?';
      for (const [key, value] of Object.entries(data)) {
        params += '&' + key + '=' + value;
      }
      return params;
    },
    layer (id, i) {
      var layer = id[i];
      var pos = layer.getBoundingClientRect();
      if(layer.querySelector('.sv')){
        if(document.querySelector('.sv_on')) document.querySelector('.sv_on').classList.remove('sv_on');
        layer.querySelector('.sv').classList.add('sv_on');
        layer.querySelector('.sv_on').style.top = parseInt(pos.y + 50) + "px";
        layer.querySelector('.sv_on').style.left = pos.x + "px";
      }
      var remove_on = function() {
        //if(document.querySelector('.sv_on')) document.querySelector('.sv_on').classList.remove('sv_on');
        //document.body.removeEventListener('click', remove_on, false);
      }
      setTimeout(() => {
        document.body.addEventListener('click', remove_on, false);
      },0);
    },
    move_update () {
      let self = this;
      const f = this.$refs.fboardmoveall;
      var formData = new FormData(f);
      formData.append('move_update', true);
      fetch(window.url, {
        method: "post",
        body: formData,
      })
      .then(function(response) {
        return response.json();
      })
      .then(function(data){
        if(data.msg) {
          alert(data.msg);
        }
        self.$modal.hide('sw_modal');
        self.update();
      });
    },    
    onSubmit () {
      return false;
    },
    select_copy(order) { 
      let self = this;
      const f = this.$refs.fboardlist;
      var formData = new FormData(f);
      formData.append('board_list_update', true);
      if(order == 'copy') {
        formData.append('btn_submit', '선택복사');
        formData.append('sw', 'copy');
      }
      else if(order=='move') {
        formData.append('btn_submit', '선택이동');
        formData.append('sw', 'move');
      }
      fetch(window.url, {
        method: "post",
        body: formData,
      })
      .then(function(response) {
        return response.json();
      })
      .then(function(data){
        if(data.msg) {
          alert(data.msg);
        }
        console.log(data);
        self.ao = data;
        self.$modal.show('sw_modal');
      });
    },
    fboardlist (value) {
      //const value = e.target.value;
      //console.log(e.target);
      let self = this;
      const f = this.$refs.fboardlist;
      var formData = new FormData(f);
      formData.append('board_list_update', true);
      let chk_count = 0;
      for (let i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked) chk_count++;
      }
      if (!chk_count) {
        alert(value + '할 게시물을 하나 이상 선택하세요.');
        return false;
      }
      if(value == "선택복사") {
        this.select_copy("copy");
        return;
      }

      if(value == "선택이동") {
        this.select_copy("move");
        return;
      }
      if(value == "선택삭제") {
        if(confirm('선택한 게시물을 정말 삭제하시겠습니까?\r\n한번 삭제한 자료는 복구할 수 없습니다\r\n답변글이 있는 게시글을 선택하신 경우\r\n답변글도 선택하셔야 게시글이 삭제됩니다.')){
          formData.append('btn_submit', value);
          fetch(window.url, {
            method: "post",
            body: formData,
          })
          .then(function(response) {
            return response.json();
          })
          .then(function(data){
            if(data.msg) {
              alert(data.msg);
            }else{
              console.log(self);
              self.update();
            }
          });
        }
      }    
    },
    search () {
      this.colspan = 5;
      this.col = ["2.5rem", "auto", "8rem", "4rem", "4rem"];
      let self = this;
      this.$route.query.sfl = document.getElementById('sfl').value;
      this.$route.query.stx = document.getElementById('stx').value;
      window.req_api({
        url : this.queryString(),
        list : true,
        bo_table : this.$route.params.bo_table,
      }).then(function(json){
        self.list = json;
        if(self.list.is_checkbox == true) self.colspan++;
        if(self.list.is_good == true) self.colspan++;
        if(self.list.is_nogood == true) self.colspan++;
        self.grid = 'grid-cols-' + self.colspan;
        if(self.list.is_checkbox == true) self.col.splice(0,0,['2rem']);
        if(self.list.is_good == true) self.col.push('4rem');
        if(self.list.is_nogood == true) self.col.push('4rem');
        self.colwidth = self.col.join(' ');
        document.title = json.title;
        self.$store.state.connect = json.connect;
        self.$modal.hide('Search-Modal');
        var url = '/' + self.$route.params.bo_table + self.queryString();
        window.history.pushState({}, '', url);        
      })
    },
    pageMove (page) {
      this.$route.query.page = page;
      this.update();
      //this.$router.push({ name : 'list' , params : {bo_table : this.$route.params.bo_table}, query : this.$route.query})
      var url = '/' + this.$route.params.bo_table + this.queryString();
      window.history.pushState({}, '', url);
    },
    chkall () {
      const all_chk = this.$refs.chkall[0].checked;
      var chk = document.querySelectorAll('.selec_chk');
      if(all_chk == true) {
        chk.forEach(ele => {
          ele.checked = true;
        });
      }else {
        chk.forEach(ele => {
          ele.checked = false;
        });
      }
    },
    update(){
      this.colspan = 5;
      this.col = ["2.5rem", "auto", "8rem", "4rem", "4rem"];
      let self = this;
      window.req_api({
        url : this.queryString(),
        list : true,
        bo_table : this.$route.params.bo_table,
      }).then(function(json){
        self.list = json;
        if(self.list.is_checkbox == true) self.colspan++;
        if(self.list.is_good == true) self.colspan++;
        if(self.list.is_nogood == true) self.colspan++;
        self.grid = 'grid-cols-' + self.colspan;
        if(self.list.is_checkbox == true) self.col.splice(0,0,['2rem']);
        if(self.list.is_good == true) self.col.push('4rem');
        if(self.list.is_nogood == true) self.col.push('4rem');
        self.colwidth = self.col.join(' ');
        if(!json.title) document.title = '잘못 된 접근입니다.';
        else document.title = json.title;
        self.$store.state.connect = json.connect;
      })
    }
  },
  created () {
    if(!this.$route.query.page) this.$route.query.page = 1;
    this.update();
  },
  
  /*
  beforeRouteUpdate (to, from, next) {
    console.log('route2');
    let self = this;
    this.colspan = 5;
    this.col = ["2.5rem", "auto", "8rem", "4rem", "4rem"];
    window.req_api({
      list : true,
      bo_table : to.params.bo_table,
    }).then(function(json){
      if(json.msg){
        alert(json.msg);
        self.$router.push('/');
      }
      self.list = json;
      if(self.list.is_checkbox == true) self.colspan++;
      if(self.list.is_good == true) self.colspan++;
      if(self.list.is_nogood == true) self.colspan++;
      self.grid = 'grid-cols-' + self.colspan;
      if(self.list.is_checkbox == true) self.col.splice(0,0,['2rem']);
      if(self.list.is_good == true) self.col.push('4rem');
      if(self.list.is_nogood == true) self.col.push('4rem');
      self.colwidth = self.col.join(' ');
      if(!json.title) document.title = '잘못 된 접근입니다.';
      else document.title = json.title;
      self.$store.state.connect = json.connect;
      next();
    })
  },
  */
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>

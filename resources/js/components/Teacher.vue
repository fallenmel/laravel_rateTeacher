<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                  <div class="card-header">Teacher</div>
                  <div class="container" >
                    <div class="row" id="teacher-section">
                      <div id="teacher-wrapper" class="col-sm-4" v-for="teacher in teachers">
                        <h2>{{teacher.name}}</h2>
                        <h3>{{teacher.email}}</h3>
                        <button class="btn btn-success" @click="rateTeacher(teacher)" >Rate</button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>

      <div class="modal fade" id="rateTeacherModal" 
        tabindex="-1" role="dialog" >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" 
                data-dismiss="modal" 
                aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
             <form @submit.prevent="addRating()">
                <star-rating @rating-selected ="setRating"></star-rating >
                <button type="submit" class="btn btn-success">Rate</button>
             </form>
            </div>
          </div>
        </div>
      </div>
    </div>


</template>

<script>


    export default {
      props: ['teachers'],
      mounted() {
          console.log('Component mounted.')
          console.log(this.teachers)
      },
      data(){
        return ({
          rating : '',
          current_id : '',
        })
      },
      methods:{
        rateTeacher: function(teacher){
          console.log('teacher', teacher);
          this.current_id = teacher.id;
          $('#rateTeacherModal').modal('show');
        },

        addRating(){
          console.log('pass send form');
          console.log('call api here');

          const formData = {
            id : this.current_id,
            rating : this.rating,
          }

          console.log('formData', formData);
        },

        setRating(rating){
          this.rating = rating;
        }
      }
    }
</script>

<template>
  <div>
    <table style="padding:5px;width:100%;border-collapse: collapse">
      <tr style="height:50px;background-color:red">
        <td style="text-align:center;width:30%;color:yellow;font-size:30px">
          <img class="dragon-img-left" style="vertical-align: middle;" src="../../assets/images/dragon-small.png"
               alt="Golden Dragon"
               height="50px">
          <span style="font-family:'chinese_takeawayregular'">De Gouden Draak</span>
          <img class="dragon-img-right" style="vertical-align: middle;"
               src="../../assets/images/dragon-small-flipped.png" alt="Golden Dragon"
               height="50px">
        </td>
        <td>
          <a href="paginas/aanbiedingen.html" style="color:yellow;font-weight:bold;text-decoration: none;">
            <marquee behavior="scroll" direction="left">
              Welkom bij De Gouden Draak. Klik op deze tekst om de aanbiedingen van deze week te zien!
            </marquee>
          </a>
        </td>
        <td style="text-align:center;width:30%;color:yellow;font-size:30px">
          <img class="dragon-img-left" style="vertical-align: middle;" src="../../assets/images/dragon-small.png"
               alt="Golden Dragon"
               height="50px">
          <span style="font-family:'chinese_takeawayregular'">De Gouden Draak</span>
          <img class="dragon-img-right" style="vertical-align: middle;"
               src="../../assets/images/dragon-small-flipped.png" alt="Golden Dragon"
               height="50px">
        </td>
      </tr>
    </table>
    <table id="main_table" style="padding:5px;width:100%;border-collapse: collapse">
      <tr style="height:7px;background-color:red">
        <td colspan="9">
        </td>
      <tr>
      <tr style="height:25px;background-color:red">
        <td width="7px"/>
        <td style="width:25px;border-left:4px solid yellow;border-top:4px solid yellow"></td>
        <td style="width:25px;border-right:4px solid yellow;border-top:4px solid yellow"></td>
        <td style="width:25px;border-right:4px solid yellow;border-bottom:4px solid yellow"></td>
        <td style="border-top:4px solid yellow;border-bottom:4px solid yellow"></td>
        <td style="width:25px;border-left:4px solid yellow;border-bottom:4px solid yellow"></td>
        <td style="width:25px;border-left:4px solid yellow;border-top:4px solid yellow"></td>
        <td style="width:25px;border-right:4px solid yellow;border-top:4px solid yellow"></td>
        <td width="7px"/>
      </tr>
      <tr style="height:25px;background-color:red">
        <td width="7px"/>
        <td style="width:25px;border-left:4px solid yellow;border-bottom:4px solid yellow"></td>
        <td style="width:25px;border:4px solid yellow"></td>
        <td style="width:25px;border:4px solid yellow"></td>
        <td></td>
        <td style="width:25px;border:4px solid yellow"></td>
        <td style="width:25px;border:4px solid yellow"></td>
        <td style="width:25px;border-right:4px solid yellow;border-bottom:4px solid yellow"></td>
        <td width="7px"/>
      </tr>
      <tr style="height:25px;background-color:red">
        <td width="7px">
        <td style="width:25px;border-right:4px solid yellow;border-bottom:4px solid yellow"></td>
        <td style="width:25px;border:4px solid yellow"></td>
        <td style="width:25px"></td>
        <td></td>
        <td style="width:25px"></td>
        <td style="width:25px;border:4px solid yellow"></td>
        <td style="width:25px;border-bottom:4px solid yellow"></td>
        <td width="7px"/>
      </tr>
      <tr style="height:50px;background-color:red">
        <td width="7px"/>
        <td style="width:25px;border-right:4px solid yellow;border-left:4px solid yellow"></td>
        <td style="width:25px;"></td>
        <td style="width:25px;"></td>
        <td style="text-align:center">
          <!-- CONTENT HERE! -->
          <table width=100%>
            <tr>
              <td colspan='3'>
                <p>
                  <img src="../../assets/images/dragon-small.png" style="float:left;height:200px" alt="Golden Dragon">
                  <img src="../../assets/images/dragon-small-flipped.png" style="float:right;height:200px"
                       alt="Golden Dragon">
                  <span style="font-size:40px;font-weight:bold;color:yellow">Chinees Indische Specialiteiten</span><br>
                  <span style="font-size:50px;font-weight:bold;color:yellow">De Gouden Draak</span><br>
                </p>
                <page-links/>
              </td>
            </tr>
            <tr style="padding-top:50px">
              <td colspan="3" height="50px">
              </td>
            </tr>
            <slot></slot>
          </table>
          <br>
          <div text-align="center">
            <router-link to="/contact">Naar Contact</router-link>
          </div>
        </td>
        <td style="width:25px;"></td>
        <td style="width:25px;"></td>
        <td style="width:25px;border-right:4px solid yellow;border-left:4px solid yellow"></td>
        <td width="7px"/>
      </tr>
      <tr style="height:25px;background-color:red">
        <td width="7px">
        <td style="width:25px;border-right:4px solid yellow;border-top:4px solid yellow"></td>
        <td style="width:25px;border:4px solid yellow"></td>
        <td style="width:25px"></td>
        <td></td>
        <td style="width:25px"></td>
        <td style="width:25px;border:4px solid yellow"></td>
        <td style="width:25px;border-top:4px solid yellow"></td>
        <td width="7px"/>
      </tr>
      <tr style="height:25px;background-color:red">
        <td width="7px"/>
        <td style="width:25px;border-left:4px solid yellow;border-top:4px solid yellow"></td>
        <td style="width:25px;border:4px solid yellow"></td>
        <td style="width:25px;border:4px solid yellow"></td>
        <td></td>
        <td style="width:25px;border:4px solid yellow"></td>
        <td style="width:25px;border:4px solid yellow"></td>
        <td style="width:25px;border-right:4px solid yellow;border-top:4px solid yellow"></td>
        <td width="7px"/>
      </tr>
      <tr style="height:25px;background-color:red">
        <td width="7px"/>
        <td style="width:25px;border-left:4px solid yellow;border-bottom:4px solid yellow"></td>
        <td style="width:25px;border-right:4px solid yellow;border-bottom:4px solid yellow"></td>
        <td style="width:25px;border-right:4px solid yellow"></td>
        <td style="border-top:4px solid yellow;border-bottom:4px solid yellow"></td>
        <td style="width:25px;border-left:4px solid yellow;"></td>
        <td style="width:25px;border-left:4px solid yellow;border-bottom:4px solid yellow"></td>
        <td style="width:25px;border-right:4px solid yellow;border-bottom:4px solid yellow"></td>
        <td width="7px"/>
      </tr>
      <tr style="height:7px;background-color:red">
        <td colspan="9"/>
      </tr>
    </table>
  </div>
</template>

<script>
import PageLinks from '@/components/website/PageLinks';

export default {
  name: 'DragonPage',
  components: {PageLinks}
};
</script>

<style lang="scss">
  .dragon-img-left {
    padding: 0 9px 0 0;
  }

  .dragon-img-right {
    padding: 0 0 0 9px;
  }
</style>

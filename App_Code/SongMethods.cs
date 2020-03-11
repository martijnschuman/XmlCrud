using System;
using System.Collections.Generic;
using System.Web;
using System.Data;
using System.Linq;

namespace XmlCrud.App_Code
{
    public class SongMethods
    {
        //Pagina 9
        public DataSet GetAllSongs()
        {
            DataSet ds = new DataSet("playlist");

            DataTable dtSongs = new DataTable("songs");

            DataColumn dcId = new DataColumn("id");
            DataColumn dcArtist = new DataColumn("artist");
            DataColumn dcTitle = new DataColumn("title");

            dtSongs.Columns.Add(dcId);
            dtSongs.Columns.Add(dcArtist);
            dtSongs.Columns.Add(dcTitle);
            ds.Tables.Add(dtSongs);

            ds.ReadXml(HttpContext.Current.Server.MapPath("~/App_Data/PlayList.xml"));

            return ds;
        }
    }
}
using System;
using System.Collections.Generic;
using System.Web;
using System.Data;
using System.Linq;

namespace XmlCrud.App_Code
{
    public class SongMethods
    {
        DataSet ds = new DataSet("playlist");

        public DataSet GetAllSongs(string file)
        {
            DataTable dtSongs = new DataTable("songs");

            DataColumn dcId = new DataColumn("id");
            DataColumn dcTitle = new DataColumn("title");
            DataColumn dcArtist = new DataColumn("artist");
            DataColumn dcAlbum = new DataColumn("album");
            DataColumn dcCover = new DataColumn("cover");
            DataColumn dcFileLocation = new DataColumn("fileLocation");

            dtSongs.Columns.Add(dcId);
            dtSongs.Columns.Add(dcTitle);
            dtSongs.Columns.Add(dcArtist);
            dtSongs.Columns.Add(dcAlbum);
            dtSongs.Columns.Add(dcCover);
            dtSongs.Columns.Add(dcFileLocation);
            ds.Tables.Add(dtSongs);

            ds.ReadXml(HttpContext.Current.Server.MapPath(file));

            return ds;
        }
        //Pagina 9

        public DataRow GetEmptyDataRow()
        {
            DataRow dr = ds.Tables["songs"].NewRow();
            return dr;
        }

        public void CreateSong(DataRow dataRow, string file)
        {
            ds.Tables["songs"].Rows.Add(dataRow);
            ds.WriteXml(HttpContext.Current.Server.MapPath(file));
        }
        //Pagina 14

        public void DeleteSong(string id, string file)
        {
            DataRow[] drArray = ds.Tables["songs"].Select("id = '" + id + "'");
            if(drArray != null && drArray.Length > 0)
            {
                drArray[0].Delete();
                ds.WriteXml(HttpContext.Current.Server.MapPath(file));
            }
        }
        //Pagina 19
        public void EditSong(string id, string file)
        {
            DataRow[] drArray = ds.Tables["songs"].Select("id = '" + id + "'");
            if (drArray != null && drArray.Length > 0)
            {
                ds.WriteXml(HttpContext.Current.Server.MapPath(file));
            }
        }

    }
}
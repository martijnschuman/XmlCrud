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
        public void EditSong( string id, string title, string artist, string album, string cover, string fileLocation, string file)
        {
            /*DataRow[] drArray = ds.Tables["songs"].Select("id = '" + id + "'");
            {
                drArray[0].Delete();
                ds.WriteXml(HttpContext.Current.Server.MapPath(file));
            }

            DataRow dr = ds.Tables["songs"].NewRow();
            dr[0] = id;
            dr[1] = title;
            dr[2] = artist;
            dr[3] = album;
            dr[4] = cover;
            dr[5] = fileLocation;

            ds.Tables["songs"].Rows.Add(dr);
            ds.WriteXml(HttpContext.Current.Server.MapPath(file));*/

            DataRow[] drArray = ds.Tables["songs"].Select("id = '" + id + "'");
            {
                drArray[0][0] = id;
                drArray[0][1] = title;
                drArray[0][2] = artist;
                drArray[0][3] = album;
                drArray[0][4] = cover;
                drArray[0][5] = fileLocation;
            }
            ds.Tables["songs"].Rows.Add(drArray);
            ds.WriteXml(HttpContext.Current.Server.MapPath(file));

        }
    }
}
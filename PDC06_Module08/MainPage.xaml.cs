using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Xamarin.Forms;

using System.Net.Http;
using Newtonsoft.Json;
using System.Runtime.CompilerServices;
using System.Collections.ObjectModel;

namespace PDC06_Module08
{
    public class Post
    { 
        public int ID { get; set; } 
        public string username { get; set; }
        public string password { get; set; }
    
    }

    public partial class MainPage : ContentPage
    {
        public const string url = "http://172.16.4.96/pdc6/api_create.php";
        public const string url_retrieve = "http://172.16.4.96/pdc6/api_r2.php";

        private HttpClient _Client = new HttpClient();
        private ObservableCollection<Post> _post;


        public MainPage()
        {
            InitializeComponent();
        }

        private async void OpenPageSearch(object sender, EventArgs e)
        {
            await Navigation.PushAsync(new SearchPage());
        }
        private async void OnAdd(object sender, System.EventArgs e) 
        {
            Post post = new Post { username = xUsername.Text, password = xPassword.Text };

            var content = JsonConvert.SerializeObject(post);

            await _Client.PostAsync(url, new StringContent(content, Encoding.UTF8, "application/json"));

            _post.Insert(0, post);


            var content2 = await _Client.GetStringAsync(url_retrieve);
            var post2 = JsonConvert.DeserializeObject<List<Post>>(content2);

            _post = new ObservableCollection<Post>(post2);
            Post_List.ItemsSource = _post;
            base.OnAppearing();

        }

        protected override async void OnAppearing()
        {
            var content = await _Client.GetStringAsync(url_retrieve);
            var post = JsonConvert.DeserializeObject<List<Post>>(content);

            _post = new ObservableCollection<Post>(post);
            Post_List.ItemsSource = _post;
            base.OnAppearing();

        }

        private async void OnRefresh(object sender, System.EventArgs e)
        {
            var content = await _Client.GetStringAsync(url_retrieve);
            var post = JsonConvert.DeserializeObject<List<Post>>(content);

            _post = new ObservableCollection<Post>(post);
            Post_List.ItemsSource = _post;
            base.OnAppearing();
        }

        

    }
}
# City Pantry Bankend Application
City Pantry backend to search its database of vendors for menu items available given day, time, location and a headcount.

### Setup
1. Clone this repo to your local machine
```
git clone https://github.com/daltino/CityPantryBankend.git
```

### To run a search on the CityPantry vendors list
```
cd CityPantryBackend
php -q index.php "src/Data/vendors-data" <deliver-day> <deliver-time> <location> <covers>
```
Example command:
```
php -q app/index.php "vendors-data" "06/10/18" "15:00" "E32NY" 50
```

### To Run Tests locally using PHPUnit
```
cd CityPantryBackend
phpunit --colors src/Test/Unit/MenuItemTest.php
phpunit --colors src/Test/Unit/OrderTest.php
phpunit --colors src/Test/Unit/VendorTest.php
```

### To build Docker container and test locally
1. Install docker on your machine and run:
```
cd CityPantryBackend
docker build -t <your-namespace>/city-pantry-backend:v0.0.1 .
```
2. Run and shell into the conatainer:
```
docker run -it -p 8080:80 --name citypantry-app <your-namespace>/city-pantry-backend:v0.0.2 /bin/bash
```
3. Execute a test on the API:
```
php -q app/index.php "vendors-data" "06/10/18" "15:00" "E32NY" 50
```
4. Exit and remove the running container
```
exit
docker rm citypantry-app
```

### To Deploy on GCP Kubernetes Engine
Note: While following these steps please update the '<gcp-project-id>' to your GCP project ID respectively.

1. Download and install gcloud, then configure your environment, setting the GCP project and following the prompts:
```
gcloud init
```
2. Build the Docker using Google Cloud Builds
```
gcloud builds submit --tag gcr.io/<gcp-project-id>/city-pantry-backend:v0.0.1 .
```
3. Create a Kubernetes deployment on GCP to handle replications by creating a cluster, installing kubectl,
creating a Kubernetes deployment and enabling autoscaling.
```
gcloud container clusters create city-pantry-cluster --num-nodes 1 \
        --enable-autoscaling --min-nodes 1 --max-nodes 10 --zone europe-west1

gcloud components install kubectl

kubectl run city-pantry-backend-deployment --image=gcr.io/<gcp-project-id>/city-pantry-backend:v0.0.1 \
            --port 8080 -l app=city-pantry-backend

kubectl autoscale deployment city-pantry-backend-deployment --max 15 --min 2 --cpu-percent 80
```

4. You can shell into the pods running by first getting the list of pods:
```
kubectl get pods
kubectl exec -it <pod-name> -- /bin/bash
```
5. Execute a test on the API to ensure its working:
```
php -q app/index.php "vendors-data" "06/10/18" "15:00" "E32NY" 50
```
6. To disable the cluster, run the following:
```
gcloud container clusters update city-pantry-cluster --enable-autoscaling \
    --min-nodes 0 --max-nodes 10 --node-pool default-pool

gcloud container clusters resize city-pantry-cluster --size=0
```

### Improvements
1. Expose the Kubernetes deployment to the internet and provisioning the right security rules.
2. Make use of a MongoDB to store and retrieve the vendors
3. Deploy the MongoDB instance to the cluster, enabling replication.